<?php

class StoreController extends SellerController {

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Store;
        $model = $model->findByPk(Yii::app()->user->getId());

        if (!$model)
            throw new CHttpException(404, '店铺不存在！');

        if (isset($_POST['Store']['name']))
        {
            $model->attributes = $_POST['Store'];
            if ($_FILES['Store']['error']['logo'] == 0)
            {
                $model->logo = CUploadedFile::getInstance($model, 'logo');
                $filename = md5_file($_FILES['Store']['tmp_name']['logo']) . '.' . $model->logo->getExtensionName();
                $model->logo->saveAs('assets/uploads/store/logo/' . $filename);
                $model->logo = '/assets/uploads/store/logo/' . $filename;
            }

            if ($model->save())
            {
                $this->redirect($this->createUrl('./store'));
            }
        }


        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionCategory()
    {
        if ($_POST)
        {
            $data = $this->request->getPost('cat');
            $saveIds = array();
            foreach ($data as $i => $v)
            {
                if ($v['name'] == '')
                    continue;
                if (isset($v['id']))
                {
                    $model = StoreCategory::model()->findByAttributes(array('store_id' => Yii::app()->user->getId(), 'id' => $v['id']));
                }
                else
                {
                    $model = new StoreCategory;
                }
                $model->name = $v['name'];
                $model->store_id = Yii::app()->user->getId();
                $model->sort_order = $v['sort_order']; //$i;
                $model->is_show = isset($v['is_show']) ? 1 : 0;
                if ($model->save())
                {
                    $saveIds[] = $model->getPrimaryKey();
                    if (!isset($v['sub']))
                        continue;
                    foreach ($v['sub'] as $ii => $sub)
                    {
                        if ($sub['name'] == '')
                            continue;
                        if (isset($sub['id']))
                        {
                            $subMmodel = StoreCategory::model()->findByAttributes(array('store_id' => Yii::app()->user->getId(), 'id' => $sub['id']));
                        }
                        else
                        {
                            $subMmodel = new StoreCategory;
                        }
                        $attributes = array(
                            'name' => $sub['name'],
                            'parent_id' => $model->getPrimaryKey(),
                            'store_id' => Yii::app()->user->getId(),
                            'sort_order' => $sub['sort_order'], //$ii,
                            'is_show' => isset($sub['is_show']) ? 1 : 0,
                        );
                        $subMmodel->attributes = $attributes;
                        if ($subMmodel->save())
                        {
                            $saveIds[] = $subMmodel->getPrimaryKey();
                        }
                    }
                }
            }
            StoreCategory::model()->deleteAll(' store_id = ' . Yii::app()->user->getId() . ' AND id NOT IN (' . implode(',', $saveIds) . ')');

            $this->redirect($this->createUrl('store/category?msg=suc'));
        }
        $categories = StoreCategory::model()->findAllByAttributes(array('store_id' => Yii::app()->user->getId(), 'parent_id' => 0));

        $this->render('category', array(
            'model' => StoreCategory::model(),
            'categories' => $categories,
        ));
    }

    function actionPromotions()
    {
        $this->title = '优惠设置';
        $model = StorePromotions::model()->findByAttributes(array('store_id' => Yii::app()->user->getId()));
        if (!$model)
            $model = new StorePromotions;
        if ($_POST)
        {
            $model->attributes = $_POST['StorePromotions'];
            $model->store_id = Yii::app()->user->getId();
            $model->save();
        }
        $this->render('promotions', array(
            'model' => $model,
        ));
    }

}
