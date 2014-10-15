<?php

class ItemCatsController extends ApiController {

    function init()
    {
        parent::init();
    }

    public function actionGet()
    {
        $parent_cid = (string) $this->request->getQuery('parent_cid', '0');
        $rs = ItemCats::model()->queryAll('parent_cid=:parent_cid AND status = 1', array(':parent_cid' => $parent_cid), 'sort_order asc');

        $this->data['ret'] = 0;
        $this->data['v'] = $rs;
    }

}
