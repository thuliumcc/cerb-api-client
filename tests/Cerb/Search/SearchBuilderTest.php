<?php
use Cerb\Search\Operator;
use Cerb\Search\Order;
use Cerb\Search\SearchBuilder;

class SearchBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBuildQuick()
    {
        //given
        $searchBuilder = SearchBuilder::instance()
            ->addQuick('name:R*');

        //when
        $toArray = $searchBuilder->toArray();

        //then
        $expected = [
            ['q', 'name:R*']
        ];
        $this->assertEquals($expected, $toArray);
    }

    /**
     * @test
     */
    public function shouldBuildCriteria()
    {
        //given
        $searchBuilder = SearchBuilder::instance()
            ->addCriteria('org_id', Operator::EQ, '1');

        //when
        $toArray = $searchBuilder->toArray();

        //then
        $expected = [
            ['criteria[]', 'org_id'],
            ['oper[]', '='],
            ['value[]', '1']
        ];
        $this->assertEquals($expected, $toArray);
    }

    /**
     * @test
     */
    public function shouldBuildSortBy()
    {
        //given
        $searchBuilder = SearchBuilder::instance()
            ->addSortBy('id', Order::DESC);

        //when
        $toArray = $searchBuilder->toArray();

        //then
        $expected = [
            ['sortBy', 'id'],
            ['sortAsc', '0']
        ];
        $this->assertEquals($expected, $toArray);
    }

    /**
     * @test
     */
    public function shouldBuildLimit()
    {
        //given
        $searchBuilder = SearchBuilder::instance()
            ->addLimit(5);

        //when
        $toArray = $searchBuilder->toArray();

        //then
        $expected = [
            ['limit', 5]
        ];
        $this->assertEquals($expected, $toArray);
    }

    /**
     * @test
     */
    public function shouldBuildPage()
    {
        //given
        $searchBuilder = SearchBuilder::instance()
            ->addPage(3);

        //when
        $toArray = $searchBuilder->toArray();

        //then
        $expected = [
            ['page', 3]
        ];
        $this->assertEquals($expected, $toArray);
    }
}
