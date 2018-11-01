<?php

namespace XTrait\Stream\Factory {

    use XTrait\Stream\FlagInterface;
    use Psr\Http\Message\StreamInterface as PsrStreamInterface;
    use XTrait\Stream\StreamInterface;

    trait AbstractTrait
    {
        /**
         * @return static
         */
        abstract public static function getInstance();

        /**
         * @param string $content
         * @return StreamInterface|PsrStreamInterface
         */
        abstract public function createStream(
            string $content = ''
        ): PsrStreamInterface;

        /**
         * @param string $filename
         * @param string $mode
         * @param bool $useIncludePath
         * @param resource|object|null $context
         * @return StreamInterface|PsrStreamInterface
         */
        abstract public function createStreamFromFile(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN,
            bool $useIncludePath = false,
            object $context = null
        ): PsrStreamInterface;

        /**
         * @param resource $resource
         * @return StreamInterface|PsrStreamInterface
         */
        abstract public function createStreamFromResource(
            $resource
        ): PsrStreamInterface;
    }
}