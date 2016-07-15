<?php

namespace Xiag\Rql\ParserTests;

use Xiag\Rql\Parser\Lexer;
use Xiag\Rql\Parser\Parser;
use Xiag\Rql\Parser\Query;
use Xiag\Rql\Parser\QueryBuilder;
use Xiag\Rql\Parser\NodeParser;
use Xiag\Rql\Parser\Node;
use Xiag\Rql\Parser\Glob;
use Xiag\Rql\Parser\Exception\SyntaxErrorException;

class WsxParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param string $rql
     * @param Query $expected
     * @return void
     *
     * @dataProvider dataParse()
     */
    public function testParse( $rql, Query $expected )
    {
        $lexer  = new Lexer();
        $parser = new Parser();

        $this->assertSame(
                var_export( $expected, true ), var_export( $parser->parse( $lexer->tokenize( $rql ) ), true )
        );
    }

    /**
     * @return array
     */
    public function dataParse()
    {
        return [
            'fiql operators generated by dstore 1' => [
                'select(type,sum(price_vat),max(distance))&route%5Fid=25&email=ne=test%5F1%40test%2Ddomain%2Ecom&email=match=%20nobody%40example%2E*&status=in=(draft_one,canceled)&status=out=(confirmed,paid)&start%5Fdate=gte=2016-09-01&end%5Fdate=lte=2016-09-30T23:59:00Z&groupby(type)&sort(+type,-start%5Ftime)&limit(25,100)',
                        (new QueryBuilder() )
                        ->addSelect( new Node\SelectNode( [
                            'type',
                            new Node\AggregateFunctionNode( 'sum', 'price_vat' ),
                            new Node\AggregateFunctionNode( 'max', 'distance' )
                        ] ) )
                        ->addQuery( new Node\Query\ScalarOperator\EqNode( 'route_id', 25 ) )
                        ->addQuery( new Node\Query\ScalarOperator\NeNode( 'email', 'test_1@test-domain.com' ) )
                        ->addQuery( new Node\Query\ScalarOperator\LikeNode( 'email', new Glob( " nobody@example.*" ) ) )
                        ->addQuery( new Node\Query\ArrayOperator\InNode( 'status', ['draft_one', 'canceled' ] ) )
                        ->addQuery( new Node\Query\ArrayOperator\OutNode( 'status', ['confirmed', 'paid' ] ) )
                        ->addQuery( new Node\Query\ScalarOperator\GeNode( 'start_date', new \DateTime( '2016-09-01T00:00:00Z' ) ) )
                        ->addQuery( new Node\Query\ScalarOperator\LeNode( 'end_date', new \DateTime( '2016-09-30T23:59:00Z' ) ) )
                        ->addGroupby( new Node\GroupbyNode( ['type' ] ) )
                        ->addSort( new Node\SortNode( ['type' => Node\SortNode::SORT_ASC, 'start_time' => Node\SortNode::SORT_DESC ] ) )
                        ->addLimit( new Node\LimitNode( 25, 100 ) )
                        ->getQuery()
            ]
        ];
    }

    private function encodeString( $value )
    {
        return strtr( rawurlencode( $value ), [
            '-' => '%2D',
            '_' => '%5F',
            '.' => '%2E',
            '~' => '%7E',
                ] );
    }

}
