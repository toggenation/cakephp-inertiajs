<?php
declare(strict_types=1);

namespace Inertia\Test\TestCase\View;

use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Cake\View\ViewBuilder;
use Inertia\View\InertiaWebView;

class InertiaWebViewTest extends TestCase
{
    public InertiaWebView $View;

    public function setUp(): void
    {
        parent::setUp();

        $request = new ServerRequest();
        $response = new Response();

        $this->View = (new ViewBuilder())
            ->setClassName('Inertia\View\InertiaWebView')
            ->setOption('_nonInertiaProps', ['one', 'two', 'three'])
            ->build([], $request, $response);
    }

    public function testRendersDivWithIdAppAttribute()
    {
        $this->View->set('user', ['id' => 1, 'name' => 'John Doe']);

        $result = $this->View->render();

        $this->assertStringContainsString('<div id="app"', $result);
        $this->assertStringContainsString(htmlentities('"props":{"user":{"id":1,"name":"John Doe"}}'), $result);
    }

    public function testRendersComponentName()
    {
        $this->View->set('component', 'Users/Index');
        $this->View->set('user', ['id' => 1, 'name' => 'John Doe']);

        $result = $this->View->render();

        $this->assertStringContainsString('&quot;Users\/Index&quot', $result);
    }

    public function testItCanPassthruVarsToCake()
    {
        $this->View->set('component', 'Users/Index');
        $this->View->set('user', ['id' => 1, 'name' => 'John Doe']);
        $this->View->set('one', 1);
        $this->View->set('two', 2);
        $this->View->set('three', 3);

        $actual = $this->View->getVars();

        $expected = [
            'three',
            'two',
            'one',
            'user',
            'component',
        ];

        $this->assertEquals($expected, $actual);

        $result = $this->View->render();

        $actual = $this->View->getVars();

        $expected = [
            'page',
            'three',
            'two',
            'one',
        ];

        $this->assertEquals($expected, $actual);
    }
}
