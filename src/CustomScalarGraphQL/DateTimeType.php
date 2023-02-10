<?php

namespace App\CustomScalarGraphQL;


use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType as ScalarTypeAlias;
use Overblog\GraphQLBundle\Annotation as GQL;

/**
 * Class DatetimeType
 *
 * @GQL\Scalar(name="DateTime")
 */
class DateTimeType extends ScalarTypeAlias
{
    /**
     * @param \DateTime $value
     *
     * @return string
     */
    public function serialize($value)
    {
        return $value->format('Y-m-d H:i:s');
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function parseValue($value)
    {
        return new \DateTime($value);
    }

    /**
     * @param Node $valueNode
     *
     * @return \DateTime
     */
    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        return new \DateTime($valueNode->value);
    }

}