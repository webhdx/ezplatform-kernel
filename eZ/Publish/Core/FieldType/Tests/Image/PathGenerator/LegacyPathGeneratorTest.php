<?php
/**
 * File containing the LegacyPathGeneratorTest class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\FieldType\Tests\Image\PathGenerator;

use eZ\Publish\Core\FieldType\Image\PathGenerator\LegacyPathGenerator;
use PHPUnit_Framework_TestCase;

/**
 * @group fieldType
 * @group ezimage
 */
class LegacyPathGeneratorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param mixed $data
     * @param mixed $expectedPath
     *
     * @dataProvider provideStoragePathForFieldData
     *
     * @return void
     */
    public function testGetStoragePathForField( $data, $expectedPath )
    {
        $pathGenerator = new LegacyPathGenerator();

        $this->assertEquals(
            $expectedPath,
            $pathGenerator->getStoragePathForField(
                $data['fieldId'],
                $data['versionNo'],
                $data['languageCode']
            )
        );
    }

    public function provideStoragePathForFieldData()
    {
        return array(
            array(
                array(
                    'fieldId' => 42,
                    'versionNo' => 1,
                    'languageCode' => 'eng-US'
                ),
                '0/0/4/2/42-1-eng-US',
            ),
            array(
                array(
                    'fieldId' => 23,
                    'versionNo' => 42,
                    'languageCode' => 'ger-DE'
                ),
                '0/0/2/3/23-42-ger-DE',
            ),
            array(
                array(
                    'fieldId' => 123456,
                    'versionNo' => 2,
                    'languageCode' => 'eng-GB'
                ),
                '1/2/3/4/123456-2-eng-GB',
            ),
        );
    }
}
