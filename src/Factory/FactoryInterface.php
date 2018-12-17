<?php

namespace XTrait\Stream\Factory {

    use XTrait\Common;
    use XTrait\Stream\FlagInterface;
    use XTrait\Stream\StreamInterface;

    /**
     * Interface FactoryInterface, INSPIRED on the PSR's StreamFactoryInterface.
     *
     * @see \Psr\Http\Message\StreamFactoryInterface
     */
    interface FactoryInterface extends
        Common\FactoryInterface
    {
        /**
         * Create a new stream from a string.
         *
         * The stream SHOULD be created with a temporary resource.
         *
         * @param string $content String content with which to populate the stream.
         * @return StreamInterface
         */
        public static function createStream(
            string $content = ''
        ): StreamInterface;

        /**
         * Create a stream from an existing file.
         *
         * The file MUST be opened using the given mode, which may be any mode
         * supported by the `fopen` function.
         *
         * The `$filename` MAY be any string supported by `fopen()`.
         *
         * @param string $filename Filename or stream URI to use as basis of stream.
         * @param string $mode Mode with which to open the underlying filename/stream.
         * @return StreamInterface
         */
        public static function createStreamFromFile(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN
        ): StreamInterface;

        /**
         * Create a new stream from an existing resource.
         *
         * The stream MUST be readable and may be writable.
         * @param resource|object $resource PHP resource to use as basis of stream.
         * @return StreamInterface
         */
        public static function createStreamFromResource(
            object $resource
        ): StreamInterface;
    }
}