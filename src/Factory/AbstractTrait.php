<?php

namespace XTrait\Stream\Factory {

    use XTrait\Stream\FlagInterface;
    use Psr\Http\Message\StreamInterface;
    use XTrait\Stream\LateStreamInterface;

    trait AbstractTrait
    {
        /**
         * @return static
         */
        abstract public static function getInstance();

        /**
         * @param string $content
         * @return LateStreamInterface|StreamInterface
         */
        abstract public function createStream(
            string $content = ''
        ): StreamInterface;

        /**
         * @param string $filename
         * @param string $mode
         * @return LateStreamInterface|StreamInterface
         */
        abstract public function createStreamFromFile(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN
        ): StreamInterface;

        /**
         * @param resource $resource
         * @return LateStreamInterface|StreamInterface
         */
        abstract public function createStreamFromResource(
            $resource
        ): StreamInterface;
    }
}