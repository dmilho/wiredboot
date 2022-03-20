<?php

namespace Dmilho\Wiredboot;

use ReflectionClass as RC;
use Illuminate\Support\Str;
use ReflectionMethod as RM;
use ReflectionProperty as RP;

abstract class Wiredboot
{


    // public function loadView($props="")
    // {
    //     return $this->view()->with($this->buildViewData($props));
    // }


    /**
     * Return ke-bab case of camelCase class name
     *
     * @return string
     */
    public function viewName()
    {
        return Str::kebab( class_basename($this) );
    }


    /**
     * Load view for wiredboot component
     *
     * @return \Illuminate\view\view
     */
    public function view()
    {
        return view("wiredboot.{$this->viewName()}");
    }


    /**
     * Undocumented function
     *
     * @param [type] $props
     * @return void
     */
    protected function buildViewData()
    {

        $viewData = [];

        foreach ((new RC($this))->getProperties(RP::IS_PUBLIC) as $property) {
           $viewData[$property->getName()] = $property->getValue($this);
        }

        foreach ((new RC($this))->getMethods(RM::IS_PUBLIC) as $method) {
            if (! in_array($name = $method->getName(), ['view', 'render', '__toString']) ) {
                // $viewData[$name] = $this->$name();
                $viewData[$name] = $method->getClosure($this);
            }
        }

        return $viewData;
    }

    public static function render()
    {
        return new static;
    }

    public function __toString()
    {
        // dd(__DIR__);
        // dd(resource_path());
        return $this->view()->with( $this->buildViewData() )->__toString();
    }
}
