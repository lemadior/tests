<?php

namespace Classes;

class Transliteration
{
    const array UKR_TRANSLIT_MAP = [
        'а' => ['a'], 'б' => ['b'], 'в' => ['v'],
        'г' => ['h'], 'ґ' => ['g'], 'д' => ['d'],
        'е' => ['e'], 'є' => ['ye', 'ie'], 'ж' => ['zh'],
        'з' => ['z'], 'и' => ['y'], 'і' => ['i'],
        'ї' => ['yi', 'i'], 'й' => ['y', 'i'], 'к' => ['k'],
        'л' => ['l'], 'м' => ['m'], 'н' => ['n'],
        'о' => ['o'], 'п' => ['p'], 'р' => ['r'],
        'с' => ['s'], 'т' => ['t'], 'у' => ['u'],
        'ф' => ['f'], 'х' => ['kh'], 'ц' => ['ts'],
        'ч' => ['ch'], 'ш' => ['sh'], 'щ' => ['shch'],
        'ю' => ['yu', 'iu'], 'я' => ['ya', 'ia']
    ];

    const array UKR_YOTTED_LETTER = ['є', 'ї', 'й', 'ю', 'я'];

    const string ENCODING = 'UTF-8';

    /**
     * Logical variable indicated start of the new word
     *
     * @var $isNewWord bool
     */
    protected bool $isNewWord = false;

    public function __construct() {
        mb_internal_encoding(self::ENCODING);
    }

    /**
     * Transliteration starts from here
     *
     * @param string $sourceString
     *
     * @return string
     */
    public function transliterate(string $sourceString): string
    {
        $this->setIsNewWord();

        $sourceArray = mb_str_split($sourceString);

        return $this->doTransliteration($sourceArray);
    }


    /**
     * Helper to proceed whole transliteration. Recursive.
     * Take array of the chars as its only argument. Then cut the last chars from array.
     * And send new result to itself recursive call (if possible)
     *
     * @param array $source
     * @return string
     */
    protected function doTransliteration(array $source): string
    {
        // Get last element from the array of chars
        $letterEnd = array_pop($source);

        // If current char is 'space' this means that next symbol may be first letter of the new word
        if ($letterEnd === ' ') {
            $this->setIsNewWord();
        }

        //If letter is Capitalized
        $isCapital = $letterEnd !== mb_strtolower($letterEnd);
        // Throw away current capitalization. It doesn't need for now.
        $letterEnd = mb_strtolower($letterEnd);

        $isNotFirstLetter = $this->getIsNewWord();

        $this->clearIsNewWord();

        // Get translitted value
        $translittedEnd = $this->getTranslittedLetter($letterEnd, $isCapital, $isNotFirstLetter);

        // Check if the current char is last element in the array
        if (count($source) === 0) {
            return $translittedEnd;
        }

        $translittedBeforeEnd = $this->doTransliteration($source);

        return $translittedBeforeEnd . $translittedEnd;
    }

    /**
     * Convert incoming char to it transliteration value
     *
     * @param string $letter    // Source char
     * @param bool $isCapital   // Flag indicating whether a capital letter is required
     * @param bool $isNotFirst  // Flag indicating that a current letter is not on first position in the word
     *
     * @return string
     */
    protected function getTranslittedLetter(string $letter, bool $isCapital = false, bool $isNotFirst = true): string
    {
        // Return any symbol that not present in the conversion map
        if (!isset(self::UKR_TRANSLIT_MAP[$letter])) {
            return $letter;
        }

        $isYotted = in_array($letter, self::UKR_YOTTED_LETTER, true);

        /**
         * For some circumstances yotted symbol can return different transliteration
         *  Therefore needs different index in associated transliteration array
         */
        $pos = $isYotted && $isNotFirst ? 1 : 0;

        $translitted = self::UKR_TRANSLIT_MAP[$letter][$pos];

        return $isCapital ? ucfirst($translitted) : $translitted;
    }

    /**
     * @return void
     */
    protected function setIsNewWord(): void {
        $this->isNewWord = true;
    }

    /**
     * @return bool
     */
    protected function getIsNewWord(): bool
    {
        return $this->isNewWord;
    }

    /**
     * @return void
     */
    protected function clearIsNewWord(): void {
        $this->isNewWord = false;
    }
}
