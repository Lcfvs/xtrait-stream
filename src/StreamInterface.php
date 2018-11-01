<?php

namespace XTrait\Stream {

    use Psr\Http\Message\StreamInterface as PsrStreamInterface;

    /**
     * Describes a late data stream.
     *
     * @see ./StreamInterface.php
     *
     * Typically, an instance of StreamInterface which doesn't requires an already
     * opened resource.
     *
     * It SHOULD be used in place of an simple StreamInterface to get an instance
     * (e.g. for an UploadedFileInterface), where the file is broken for any
     * reason, or just to avoid to open some files which aren't really used.
     */
    interface StreamInterface
        extends PsrStreamInterface
    {
        /**
         * StreamTrait constructor.
         * @param string $filename
         * @param string $mode
         * @param bool $useIncludePath
         * @param null $context
         */
        public function __construct(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN,
            bool $useIncludePath = false,
            $context = null
        );

        /**
         * Returns the stream resource, if any
         *
         * @return resource|bool|null
         */
        public function getResource();

        /**
         * Returns a new stream built to wrap an opened resource handle.
         *
         * @param resource $resource
         * @return static
         */
        public function withResource(
            $resource
        );

        /**
         * Tries to open the resource (if needed)
         *
         * Implementers MUST define/override all the StreamInterface's methods to
         * call it before to do their job.
         *
         * @return $this
         */
        public function open();

        /**
         * @param string $name
         * @param resource|object|null $context
         * @return null|static
         */
        public function rename(
            string $name,
            object $context = null
        );

        /**
         * @param int $size
         * @return bool
         */
        public function truncate(
            int $size
        );

        /**
         * Tries to unlink the resource
         *
         * @return bool
         */
        public function unlink();
    }
}