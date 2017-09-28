<?php

namespace App {

    class Lang
    {

        const LOCALE_RU = 'ru_RU';
        const LOCALE_UA = 'uk_UA';

        /**
         * @var int
         */
        private static $current_id;

        /**
         * @var string
         */
        private static $prefix;

        /**
         * @var string
         */
        private static $locale;

        /**
         * Crop lang out of locale string
         * @return mixed
         */
        public static function current()
        {
            return explode('_', self::locale())[0];
        }

        /**
         * @return int
         */
        public static function current_id()
        {
            if (isset(self::$current_id)) {
                return self::$current_id;
            }

            self::$current_id = (int)\DB::table('lang')
                ->select('lang_id')
                ->where('lang_name', self::current())
                ->value('lang_id');

            return self::$current_id;
        }

        /**
         * @return string
         */
        public static function locale()
        {
            return \App::getLocale();
        }

        /**
         * @param bool $show_ru
         * @return mixed|string
         */
        public static function getPrefix($show_ru = false)
        {
            if (isset(self::$prefix) && func_num_args() <= 0) {
                // Return gathered value
                return self::$prefix;
            }

            $prefix = self::current();

            if ($prefix === 'uk') {
                $prefix = 'ua';
            }

            if ($prefix === 'ru' && !$show_ru) {
                $prefix = '';
            }

            if (!empty($prefix)) {
                $prefix = '_'.$prefix;
            }

            if (func_num_args() <= 0) {
                self::$prefix = $prefix;
            }

            return $prefix;
        }

    }

}

namespace {

    use \App\Lang;

    if (!function_exists('prefix')) {
        function prefix($show_ru = false)
        {
            return Lang::getPrefix($show_ru);
        }
    }

}