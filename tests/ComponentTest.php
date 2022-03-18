<?php

namespace  Tests\Feature;

use Dmilho\Wiredboot\Wiredboot;
use Orchestra\Testbench\TestCase;
use function PHPUnit\Framework\assertEquals;
use Dmilho\Wiredboot\WiredbootServiceProvider;


class ComponentTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            WiredbootServiceProvider::class
        ];
    }

    /** @test */
    function compiles_blade_directive()
    {
        $string = "@wiredboot('TestComponent')";
        $expected = "<?= resolve('App\Http\Wiredboot\TestComponent'); ?>";

        $compiled = resolve('blade.compiler')->compileString($string);

        $this->assertEquals($expected, $compiled);
    }


        /** @test */
        function sets_kebab_case_view_name_based_on_camel_case_class_name()
        {
            $wiredboot = new TestWiredboot();

            $this->assertEquals( 'test-wiredboot', $wiredboot->viewName() );
        }


        /** @test */
        function confirm_all_public_properties_are_available_in_component_view()
        {
            // dump(TestWiredboot::render()->__toString());
            $this->assertStringContainsString('TITLE FROM TEST', TestWiredboot::render());
        }


        /** @test */
        function confirm_all_public_methods_are_available_in_component_view()
        {
            $checkView = TestWiredboot::render();
            // dump(TestWiredboot::render()->__toString());
            $this->assertStringContainsString('slide 1', $checkView);
            $this->assertStringContainsString('slide 2', $checkView);
            $this->assertStringContainsString('slide 3', $checkView);
        }


        /** @test */
        function renders_when_converted_to_string()
        {
            $this->assertStringContainsString('TITLE FROM TEST', new TestWiredboot);
        }


}

class TestWiredboot extends Wiredboot {
    public $title = "TITLE FROM TEST";

    public function slides()
    {
        return ['slide 1', 'slide 2', 'slide 3'];
    }

    public function view()
    {
        return view()->file(__DIR__.'/stubs/test-component.blade.php');
    }
}
