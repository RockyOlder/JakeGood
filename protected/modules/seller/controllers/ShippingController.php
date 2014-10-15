<?php

class ShippingController extends SellerController {

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Shipping;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Shipping']))
		{
			$model->attributes=$_POST['Shipping'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->ship_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

}
