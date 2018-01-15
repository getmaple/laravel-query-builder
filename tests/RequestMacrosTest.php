<?php

namespace Spatie\QueryBuilder\Tests;

use Illuminate\Http\Request;

class RequestMacrosTest extends TestCase
{
    /** @test */
    public function it_can_get_the_sort_query_param_from_the_request()
    {
        $request = new Request([
            'sort' => 'foobar',
        ]);

        $this->assertEquals('foobar', $request->sort());
    }

    /** @test */
    public function it_will_return_null_when_no_sort_query_param_is_specified()
    {
        $request = new Request();

        $this->assertNull($request->sort());
    }

    /** @test */
    public function it_can_get_the_filter_query_params_from_the_request()
    {
        $request = new Request([
            'filter' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]);

        $expected = collect([
                'foo' => 'bar',
                'baz' => 'qux',
        ]);

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_will_return_an_empty_collection_when_no_filter_query_params_are_specified()
    {
        $request = new Request();

        $expected = collect();

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_will_map_true_and_false_as_booleans_when_given_in_a_filter_query_string()
    {
        $request = new Request([
            'filter' => [
                'foo' => 'true',
                'bar' => 'false',
                'baz' => '0',
            ],
        ]);

        $expected = collect([
                'foo' => true,
                'bar' => false,
                'baz' => '0',
            ]);

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_can_return_a_specific_filters_value_from_the_filter_query_string()
    {
        $request = new Request([
            'filter' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]);

        $this->assertEquals('qux', $request->filters('baz'));
    }

    /** @test */
    public function it_can_get_the_include_query_params_from_the_request()
    {
        $request = new Request([
            'include' => 'foo,bar',
        ]);

        $expected = collect(['foo', 'bar']);

        $this->assertEquals($expected, $request->includes());
    }

    /** @test */
    public function it_will_return_an_empty_collection_when_no_include_query_params_are_specified()
    {
        $request = new Request();

        $expected = collect();

        $this->assertEquals($expected, $request->includes());
    }

    /** @test */
    public function it_knows_if_a_specific_include_from_the_query_string_is_required()
    {
        $request = new Request([
            'include' => 'foo,bar',
        ]);

        $this->assertEquals(false, $request->includes('baz'));
        $this->assertEquals(true, $request->includes('bar'));
    }
}