<?php

namespace Tests;

use App\TagParser;
use PHPUnit\Framework\TestCase;

/* Reach for data providers when you might encounter with:
 "I am just gonna need the exact same logic for
 every single test, the only difference is the 
 input and the expected"

 In order to use data providers, create a function 
 and us the following syntax as a docblock comment:
    @dataProvider <name_of_function>
*/

class TagParserTest extends TestCase
{
    public function tagsProvider()
    {
        return [
            ["personal", ["personal"]],
            ["personal, money, family", ["personal", "money", "family"]],
            ["personal,money,family", ["personal", "money", "family"]],
            ["personal | money | family", ["personal", "money", "family"]],
            ["personal|money|family", ["personal", "money", "family"]],
        ];
    }

    /**
     * @dataProvider tagsProvider
     */
    public function test_it_parses_tags($input, $expected)
    {
        // Given or Arrange
        $parser = new TagParser;

        // When or Act
        $result = $parser->parse($input);

        // Then or Assert
        $this->assertSame($expected, $result);
    }
}
