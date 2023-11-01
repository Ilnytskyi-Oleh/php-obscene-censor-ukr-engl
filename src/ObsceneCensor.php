namespace Wkhooy;

class ObsceneCensor {
    public static $log;
    public static $logEx;

    // Англійська мова
    private const LT_F = 'fF';
    private const LT_U = 'uU';
    private const LT_C = 'cC';
    private const LT_K = 'kK';
    private const LT_I = 'iI1';
    private const LT_N = 'nN';
    private const LT_G = 'gG';

    // Російська мова
    private const LT_P = 'пПnPp';
    private const LT_I = 'иИiI1u';
    private const LT_E = 'еЕeE';
    private const LT_D = 'дДdD';
    private const LT_Z = 'зЗ3zZ3';
    private const LT_M = 'мМmM';
    private const LT_U = 'уУyYuU';
    private const LT_O = 'оОoO0';
    private const LT_L = 'лЛlL';
    private const LT_S = 'сСcCsS';
    private const LT_A = 'аАaA';
    private const LT_N = 'нНhH';
    private const LT_G = 'гГgG';
    private const LT_CH = 'чЧ4';
    private const LT_K = 'кКkK';
    private const LT_C = 'цЦcC';
    private const LT_R = 'рРpPrR';
    private const LT_H = 'хХxXhH';
    private const LT_YI = 'йЙy';
    private const LT_YA = 'яЯ';
    private const LT_YO = 'ёЁ';
    private const LT_YU = 'юЮ';
    private const LT_B = 'бБ6bB';
    private const LT_T = 'тТtT';
    private const LT_HS = 'ъЪ';
    private const LT_SS = 'ьЬ';
    private const LT_Y = 'ыЫ';

    // Українська мова
    private const LT_UK = 'ґҐҜҝқҞҟҠҡҡҡҢңҤҥҦҧҨҩҨҩҫҫҬҭҮүҰұҲҳҲҳҴҵҴҵҶҷҸҹҺһҼҽҾҿ';
    private const LT_IE = 'іІI1i';
    private const LT_YI = 'їЇ';
    private const LT_E = 'ееЕeE';
    private const LT_Y = 'иІiI1u';
    private const LT_K = 'кКkK';
    private const LT_A = 'аАaA';
    private const LT_O = 'оОoO0';
    private const LT_M = 'мМmM';
    private const LT_T = 'тТtT';
    private const LT_X = 'хХxX';
    private const LT_B = 'бБ6bB';

    public static $exceptions = [
        'команд',
        'рубл',
        'премь',
        'оскорб',
        'краснояр',
        'бояр',
        'ноябр',
        'карьер',
        'мандат',
        'употр',
        'плох',
        'интер',
        'веер',
        'фаер',
        'феер',
        'hyundai',
        'тату',
        'браконь',
        'roup',
        'сараф',
        'держ',
        'слаб',
        'ридер',
        'истреб',
        'потреб',
        'коридор',
        'sound',
        'дерг',
        'подоб',
        'коррид',
        'дубл',
        'курьер',
        'экст',
        'try',
        'enter',
        'oun',
        'aube',
        'ibarg',
        '16',
        'kres',
        'глуб',
        'ebay',
        'eeb',
        'shuy',
        'ансам',
        'cayenne',
        'ain',
        'oin',
        'тряс',
        'ubu',
        'uen',
        'uip',
        'oup',
        'кораб',
        'боеп',
        'деепр',
        'хульс',
        'een',
        'ee6',
        'ein',
        'сугуб',
        'карб',
        'гроб',
        'лить',
        'рсук',
        'влюб',
        'хулио',
        'ляп',
        'граб',
        'ибог',
        'вело',
        'ебэ',
        'перв',
        'eep',
        'ying',
        'laun',
        'чаепитие',
    ];

    public static function getFiltered($text, $charset = 'UTF-8'): string {
        self::filterText($text, $charset);
        return $text;
    }

    public static function isAllowed($text, $charset = 'UTF-8'): bool {
        $original = $text;
        self::filterText($text, $charset);
        return $original === $text;
    }

    public static function filterText(string &$text, string $charset = 'UTF-8'): bool
    {
        $utf8 = 'UTF-8';

        if ($charset !== $utf8) {
            $text = iconv($charset, $utf8, $text);
        }

        preg_match_all('/
\b\d*(
	\w*[' . self::LT_P . '][' . self::LT_I . self::LT_E . '][' . self::LT_Z . '][' . self::LT_D . ']\w* # російська мова
|
	\w*[' . self::LT_F . '][' . self::LT_U . '][' . self::LT_C . '][' . self::LT_K . '][' . self::LT_I . '][' . self::LT_N . self::LT_G . self::LT_G . self::LT_G . ']\w* # англійська мова
|
	\w*[' . self::LT_UK . '][' . self::LT_IE . self::LT_YI . self::LT_E . '][' . self::LT_A . '][' . self::LT_O . '][' . self::LT_M . '][' . self::LT_T . '][' . self::LT_X . '][' . self::LT_B . ']\w* # українська мова
)\b
/xu', $text, $m);

        $c = count($m[1]);

        if ($c > 0) {
            for ($i = 0; $i < $c; $i++) {
                $word = $m[1][$i];
                $word = mb_strtolower($word, $utf8);

                foreach (self::$exceptions as $x) {
                    if (mb_stripos($word, $x) !== false) {
                        if (is_array(self::$logEx)) {
                            $t = &self::$logEx[$m[1][$i]];
                            ++$t;
                        }
                        $word = false;
                        unset($m[1][$i]);
                        break;
                    }
                }

                if ($word) {
                    $m[1][$i] = str_replace([' ', ',', ';', '.', '!', '-', '?', "\t", "\n"], '', $m[1][$i]);
                }
            }

            $m[1] = array_unique($m[1]);

            $asterisks = [];
            foreach ($m[1] as $word) {
                if (is_array(self::$log)) {
                    $t = &self::$log[$word];
                    ++$t;
                }
                $asterisks []= str_repeat('*', mb_strlen($word, $utf8));
            }

            $text = str_replace($m[1], $asterisks, $text);

            if ($charset !== $utf8) {
                $text = iconv($utf8, $charset, $text);
            }

            return true;
        } else {
            if ($charset !== $utf8) {
                $text = iconv($utf8, $charset, $text);
            }

            return false;
        }
    }
}
