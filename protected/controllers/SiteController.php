<?php

class SiteController extends CController
{
    /**
     * Declares action.
     */
    public function actions()
    {
        return array(
        );
    }

    /**
     * This is the default action that displays the api client.
     */
    public function actionIndex()
    {
        // $data = array('api'=>'test success');
        // echo json_encode($data);
        // exit;
        $models = Destinations::model()->findAll();
        echo json_encode($models);

    }
}