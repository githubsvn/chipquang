<?php
namespace SM\Bundle\AdminBundle\Utilities;

/**
 * Utilities
 */
class Utilities
{

    /**
     * Rename for file
     *
     * @param type $originalName
     *
     * @return string $newName the new file name
     */
    public static function renameForFile($originalName = '')
    {
        $newName = '';
        if (!empty($originalName)) {
            $arr = explode(".", $originalName);
            if (!empty($arr[1])) {
                $newName = uniqid() . '.' . $arr[1];
            }
        }

        return $newName;
    }

    /**
     * @param type $string    string
     * @param type $strSymbol strSymbol
     * @param type $length    length
     *
     * @return type
     */
    public static function cleanString($string, $strSymbol = '-', $length = 255)
    {
        $arrCharFrom = array(
            "ạ", "á", "à", "ả", "ã", "Ạ", "Á", "À", "Ả", "Ã",
            "â", "ậ", "ấ", "ầ", "ẩ", "ẫ", "Â", "Ậ", "Ấ", "Ầ", "Ẩ", "Ẫ",
            "ă", "ặ", "ắ", "ằ", "ẳ", "ẫ", "Ă", "Ắ", "Ằ", "Ẳ", "Ẵ", "Ặ",
            "ê", "ẹ", "é", "è", "ẻ", "ẽ", "Ê", "Ẹ", "É", "È", "Ẻ", "Ẽ",
            "ế", "ề", "ể", "ễ", "ệ", "Ế", "Ề", "Ể", "Ễ", "Ệ",
            "ọ", "ộ", "ổ", "ỗ", "ố", "ồ", "Ọ", "Ộ", "Ổ", "Ỗ", "Ố", "Ồ", "Ô", "ô",
            "ó", "ò", "ỏ", "õ", "Ó", "Ò", "Ỏ", "Õ",
            "ơ", "ợ", "ớ", "ờ", "ở", "ỡ",
            "Ơ", "Ợ", "Ớ", "Ờ", "Ở", "Ỡ",
            "ụ", "ư", "ứ", "ừ", "ử", "ữ", "ự", "Ụ", "Ư", "Ứ", "Ừ", "Ử", "Ữ", "Ự",
            "ú", "ù", "ủ", "ũ", "Ú", "Ù", "Ủ", "Ũ",
            "ị", "í", "ì", "ỉ", "ĩ", "Ị", "Í", "Ì", "Ỉ", "Ĩ",
            "ỵ", "ý", "ỳ", "ỷ", "ỹ", "Ỵ", "Ý", "Ỳ", "Ỷ", "Ỹ",
            "đ", "Đ",
            "›"
        );
        $arrCharEnd = array(
            "a", "a", "a", "a", "a", "A", "A", "A", "A", "A",
            "a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A",
            "a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A",
            "e", "e", "e", "e", "e", "e", "E", "E", "E", "E", "E", "E",
            "e", "e", "e", "e", "e", "E", "E", "E", "E", "E",
            "o", "o", "o", "o", "o", "o", "O", "O", "O", "O", "O", "O", "O", "o",
            "o", "o", "o", "o", "O", "O", "O", "O",
            "o", "o", "o", "o", "o", "o",
            "O", "O", "O", "O", "O", "O",
            "u", "u", "u", "u", "u", "u", "u", "U", "U", "U", "U", "U", "U", "U",
            "u", "u", "u", "u", "U", "U", "U", "U",
            "i", "i", "i", "i", "i", "I", "I", "I", "I", "I",
            "y", "y", "y", "y", "y", "Y", "Y", "Y", "Y", "Y",
            "d", "D",
            ""
        );

        $arrCharFilter = str_replace($arrCharFrom, $arrCharEnd, trim($string));

        if (mb_strlen($arrCharFilter, "UTF-8") > $length) {
            $arrCharFilter = mb_substr($arrCharFilter, 0, $length, "UTF-8");
        }

        $arrCharFilter = preg_replace('/[\W|_]+/', $strSymbol, $arrCharFilter);
        $arrCharFilter = trim($arrCharFilter, '-');

        return strtolower($arrCharFilter);
    }
    
    /**
     * Get root dir
     */
    public static function getRootDir()
    {
        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        return $container->get('kernel')->getRootDir() . '/../';
    }
}
