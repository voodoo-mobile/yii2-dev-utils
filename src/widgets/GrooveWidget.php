<?php
namespace vm\dev\widgets;

use yii\base\InvalidParamException;
use yii\base\Widget;

/**
 * Class GrooveWidget
 * @package yii2vm\components\widgets
 *
 ***        How to use it       ***
 *
 * In your view or layout file
 *
 * if ($params = ArrayHelper::getValue(Yii::$app->params, ['groove'])) {
 *      GrooveWidget::widget($params);
 * }
 *
 *
 * Add following string to your params file
 *
 * 'groove' => [
 *      'account' => 'ACCOUNT_NAME',
 *      'id'      => 'ID',
 * ]
 *
 */
class GrooveWidget extends Widget
{
    /**
     * @var null
     */
    public $account = null;

    /**
     * @var null
     */
    public $id = null;

    /**
     *
     */
    public function run()
    {
        if (!$this->account) {
            throw new InvalidParamException('Account must be initialized. Please refer to Groove embed script params');
        }

        if (!$this->id) {
            throw new InvalidParamException('Id must be initialized. Please refer to Groove embed script params');
        }

        $js = "(function () {
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://{{account}}.groovehq.com/widgets/{{id}}/ticket.js';
                var q = document.getElementsByTagName('script')[0];
                q.parentNode.insertBefore(s, q);
            })();";

        $js = str_replace(['{{account}}', '{{id}}'], [$this->account, $this->id], $js);
        $this->view->registerJs($js);

        parent::run();
    }
}