<?php
namespace Xiag\Rql\Parser\NodeParser;

use Xiag\Rql\Parser\Token;
use Xiag\Rql\Parser\TokenStream;
use Xiag\Rql\Parser\NodeParserInterface;
use Xiag\Rql\Parser\Node\SelectNode;
use Xiag\Rql\Parser\Node\AggregateFunctionNode;

class SelectNodeParser implements NodeParserInterface
{
    private $allowedFunctions;

    public function __construct(array $allowedFunctions)
    {
        $this->allowedFunctions = $allowedFunctions;
    }

    public function parse(TokenStream $tokenStream)
    {
        $fields = [];

        $tokenStream->expect(Token::T_OPERATOR, 'select');
        $tokenStream->expect(Token::T_OPEN_PARENTHESIS);

        do {
            if (($agregate = $tokenStream->nextIf(Token::T_OPERATOR, $this->allowedFunctions)) !== null) {
                $tokenStream->expect(Token::T_OPEN_PARENTHESIS);

                $fields[] = new AggregateFunctionNode(
                    $agregate->getValue(),
                    $tokenStream->expect(Token::T_STRING)->getValue()
                );

                $tokenStream->expect(Token::T_CLOSE_PARENTHESIS);
            } else {
                $fields[] = $tokenStream->expect(Token::T_STRING)->getValue();
            }

            if (!$tokenStream->nextIf(Token::T_COMMA)) {
                break;
            }
        } while (true);

        $tokenStream->expect(Token::T_CLOSE_PARENTHESIS);

        return new SelectNode($fields);
    }
    /**
     * @inheritdoc
     */
    public function supports(TokenStream $tokenStream)
    {
        return $tokenStream->test(Token::T_OPERATOR, 'select');
    }
}
