<?php

namespace App\Controllers;

use Swoft\App;
use Swoft\Bean\Annotation\Controller;
use Swoft\Bean\Annotation\RequestMapping;
use Swoft\Bean\Annotation\View;
use Swoft\Swagger\SwaggerAction;
use Swoft\Swagger\SwaggerApiAction;
use Swoft\Web\ViewRendererTrait;

/**
 * Class SwaggerController
 * @Controller()
 * @package App\Controllers
 */
class SwaggerController
{
    use ViewRendererTrait;

    /**
     * @RequestMapping()
     * @return string
     */
    public function actionDoc()
    {
        !empty($_SERVER['HTTP_HOST']) && !defined('API_HOST') && define("API_HOST", $_SERVER['HTTP_HOST']);
        $swaggerAction = new SwaggerAction();
        $swaggerAction->restUrl = API_HOST . '/swagger/api';
        return $swaggerAction->run();
    }

    /**
     * 视图渲染demo - 没有使用布局文件(请访问 /demo2/view)
     * @RequestMapping()
     * @View(template="@swagger/index.tpl")
     */
    public function actionDoc1()
    {
//        !empty($_SERVER['HTTP_HOST']) && !defined('API_HOST') && define("API_HOST", $_SERVER['HTTP_HOST']);
        return ['rest_url' => '/swagger/api'];
    }

    public function actionApi()
    {
        $swaggerApiAction = new SwaggerApiAction();
        $swaggerApiAction->scanDir = App::getAlias('@app') . '/docs';
        return $swaggerApiAction->execute();
    }

    /**
     * @RequestMapping()
     * @View(template="swagger/view")
     * @return array
     */
    public function actionView()
    {

        $name = 'Swagger';
        return [$name];
        $notes = [
            'hello swagger',
            'hello swagger1',
        ];
        return compact('name', 'notes');
    }

    /**
     * @RequestMapping()
     */
    public function actionTest()
    {
        return $this->renderPartial(App::getAlias('@resources') . '/views/index/index.php', []);
    }
}
