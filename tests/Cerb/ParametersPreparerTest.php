<?php

use Cerb\ParametersPreparer;

class ParametersPreparerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreatePostfieldsFromArray()
    {
        //given
        $params = [
            ['criteria[]', 'is_deleted'],
            ['oper[]', '='],
            ['value[]', '0'],
            ['criteria[]', 'group_id'],
            ['oper[]', '='],
            ['value[]', '1'],
            ['criteria[]', 'bucket_id'],
            ['oper[]', '='],
            ['value[]', '0'],
            ['criteria[]', 'mask'],
            ['oper[]', 'like'],
            ['value[]', 'e*'],
            ['sortBy', 'mask'],
            ['sortAsc', '1'],
            ['page', '1'],
        ];

        //when
        $postfields = ParametersPreparer::postfields($params);

        //then
        $expected = 'criteria[]=is_deleted&oper[]=%3D&value[]=0&criteria[]=group_id&oper[]=%3D&value[]=1&criteria[]=bucket_id&oper[]=%3D&value[]=0&criteria[]=mask&oper[]=like&value[]=e%2A&sortBy=mask&sortAsc=1&page=1';
        $this->assertEquals($expected, $postfields);
    }

    /**
     * @test
     */
    public function shouldCreatePostFieldsFromString()
    {
        //given
        $params = 'criteria[]=is_deleted&oper[]=%3D&value[]=0';

        //when
        $postfields = ParametersPreparer::postfields($params);

        //then
        $this->assertEquals('criteria[]=is_deleted&oper[]=%3D&value[]=0', $postfields);
    }

    /**
     * @test
     */
    public function shouldSortQueryString()
    {
        //given
        $queryString = '?status=active&name=Cerb&age=12';

        //when
        $sortedQueryString = ParametersPreparer::sortedUrlQueryString($queryString);

        //then
        $this->assertEquals('age=12&name=Cerb&status=active', $sortedQueryString);
    }
}
