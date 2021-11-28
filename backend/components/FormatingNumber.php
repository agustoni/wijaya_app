<?php

namespace backend\components;

use Yii;
use yii\base\Component;

class FormatingNumber extends Component {
    public function Decimal($num){
        $tmp = explode('.', floatval($num));
        if(count($tmp) > 1){
            $len = strlen(end($tmp));
        }else{
            $len = 0;
        }
        return Yii::$app->formatter->asDecimal(floatval($num), $len);
    }
}

?>