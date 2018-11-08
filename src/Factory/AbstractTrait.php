<?php

namespace XTrait\Stream\Factory {

    use XTrait\Stream\FlagInterface;
    use XTrait\Stream\StreamInterface;

    trait AbstractTrait
    {
        /**
         * @return static
         */
        abstract public static function getInstance();

        /**
         * @param string $content
         * @return StreamInterface
         */
        abstract public function createStream(
            string $content = ''
        ): StreamInterface;

        /**
         * @param string $filename
         * @param string $mode
         * @param bool $useIncludePath
         * @param resource|object|null $context
         * @return StreamInterface
         */
        abstract public function createStreamFromFile(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN,
            bool $useIncludePath = false,
            object $context = null
        ): StreamInterface;

        /**
         * @param resource $resource
         * @return StreamInterface
         */
        abstract public function createStreamFromResource(
            $resource
        ): StreamInterface;
    }
}