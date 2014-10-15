<?php

class VisitsController extends VerifyController
{
	public function actionStatistics()
	{
		$this->template = 'statistics';
		$date = date('Y-m-d', strtotime("-1 day"));
		$yesterday = VisitStatistics::model()->find('date = :date and store_id = :user_id', array(':date' => $date, ':user_id' => Yii::app()->user->getId()));

		$date = date('Y-m-d', strtotime("-7 day"));
		$model = VisitStatistics::model()->findAll('date > :date and store_id = :user_id', array(':date' => $date, ':user_id' => Yii::app()->user->getId()));
		$week = array();
		foreach ($model as $v)
		{
			$week['pv'] += $v->pv;
			$week['uv'] += $v->uv;
			$week['total'] += $v->total;
			$week['num'] += $v->num;
		}

		$date = date('Y-m-d', strtotime("-30 day"));
		$model = VisitStatistics::model()->findAll('date > :date and store_id = :user_id', array(':date' => $date, ':user_id' => Yii::app()->user->getId()));
		$month = array();
		foreach ($model as $v)
		{
			$month['pv'] += $v->pv;
			$month['uv'] += $v->uv;
			$month['total'] += $v->total;
			$month['num'] += $v->num;
		}

		$this->data['yesterday'] = $yesterday;
		$this->data['week'] = $week;
		$this->data['month'] = $month;

	}

	public function actionGetData()
	{
		$day = $this->request->getQuery('day', 7);
		$start = date('Y-m-d', strtotime("-{$day} day"));

		$model = VisitStatistics::model()->findAll('date > :start and store_id = :user_id', array(':start' => $start, ':user_id' => Yii::app()->user->getId()));
		$odata = array();
		foreach ($model as $v)
		{
			$odata['category'][] = array('label' => $v->date);
			$odata['dataset']['PV']['data'][] = array('value' => $v->pv);
			$odata['dataset']['UV']['data'][] = array('value' => $v->uv);
		}

		$data[0]['chartsType'] = 'MSLine';
		$odata['dataset']['PV']['seriesname'] = 'PV';
		$odata['dataset']['PV']['color'] = 'A66EDD';
		$odata['dataset']['UV']['seriesname'] = 'UV';
		$odata['dataset']['UV']['color'] = 'F6BD0F';

		$cdata = array('title' => '', 'data' => $odata, 'chartsType' => 'MSLine');
		$data[0]['data'] = $this->makeMultiLineChart($cdata);
		unset($odata);
		unset($cdata);
		
		echo json_encode($data);
	}


	function makeChart($group)
	{
		$data['chart'] = array( 'caption'       => $group['title'],	//标题
								'xaxisname'     => '',	//X坐标标题
								'yaxisname'     => '',	//Y坐标标题
								'numberprefix'  => '',	//前缀符号
								'useroundedges' => 1,	//0平面图，1 2D图
								'showvalues'    => 1,	//显示值
								'placeValuesInside' => 1, //1柱内显示值
								'showExportDataMenuItem' => 1, //1柱内显示值
						 );
						 
		if (stripos($group['chartsType'], 'scroll') !== FALSE)
		{
			
			
			$category = $value = array();
			foreach($group['data'] as $v)
			{
				$v = (array) $v;
				$category[]['label'] = $v['label'];
				$value[]['value']    = $v['value'];
			}
			$data['categories'][]['category'] = $category;
			$data['dataset'][] = array("seriesname" => $group['column'], 'data' => $value);
			
		}
		else
		{
		
			$datasets = array();
			foreach($group['data'] as $k => $v)
			{
				$v = (array) $v;
				if (isset($v['sub']) && count($v['sub']) > 0)
				{
					$datasets[] = array(
									"label" => $v['label'],
									"value" => $v['value'],
									"link" => 'newchart-xml-'.$v['label'],
									);
					$linkdata[] = $this->get_linkdata($v['label'], $v['sub']);
				}
				else
				{
					$datasets[] = array(
									"label" => $v['label'],
									"value" => $v['value'],
									);
				}
			}
			
			$data['data'] = $datasets;
			isset($linkdata) ? $data['linkeddata'] = $linkdata : '';
		}
		return $data;
	}
	
	
	function makeMultiLineChart($group)
	{
		$data['chart'] = array( 'caption'       => $group['title'],	//标题
								'xaxisname'     => '',	//X坐标标题
								'yaxisname'     => '',	//Y坐标标题
								'numberprefix'  => '',	//前缀符号
								"bgcolor"       => "F7F7F7, E9E9E9",
								'useroundedges' => 1,	//0平面图，1 2D图
								'showvalues'    => 1,	//显示值
								'valueposition' => 'Below',
								'canvaspadding' => 10, 
								'rotatevalues' => 1, 
						 );
			
			$data['categories'][]['category'] = $group['data']['category'];

			$data['dataset'] = $group['data']['dataset'];
			sort($data['dataset']);
			
		return $data;
	}
	
	
	function getLinkdata($label, $group)
	{
		$sql  = array_shift($sqls);
		if ( ! $sql ) return NULL;
		$data = array();
		$sql = str_ireplace(array('$label', '$begin', '$end'), array($label, $begin, $end), $sql);
		
		$data['id'] = $label;
		$data['linkedchart']['chart'] = array( 'caption'       => $label.' Ver 统计图',	//标题
												'xaxisname'     => '',	//X坐标标题
												'yaxisname'     => '',	//Y坐标标题
												'numberprefix'  => '',	//前缀符号
												'useroundedges' => 1,	//0平面图，1 2D图
												'showvalues'    => 1,	//显示值
												'placeValuesInside' => 0, //1柱内显示值
												'showExportDataMenuItem' => 0, //1柱内显示值
											);
		$res  = Database::instance('analysis')->query(Database::SELECT, $sql)->as_array();
		foreach($res as $k => $v)
		{
			if ($sqls)
			{
				$data['linkedchart']['data'][] = array(
					"label" => $v['label'],
					"value" => $v['value'],
					"link"  => 'newchart-xml-'.$v['label'],
					);
				$data['linkedchart']['linkeddata'][] = $this->get_linkdata($sqls, $v['label'], $group, $begin, $end);
			}
			else
			{
				$data['linkedchart']['data'][] = array(
					"label" => $v['label'],
					"value" => $v['value'],
					);
			}
		}
		return $data;
	}
	
}