<?php

namespace XTrait\Stream {

    trait AbstractTrait
    {
        /**
         * StreamTrait constructor.
         * @param string $filename
         * @param string $mode
         * @param bool $useIncludePath
         * @param resource|object|null $context
         */
        abstract public function __construct(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN,
            bool $useIncludePath = false,
            object $context = null
        );

        /**
         * @return string
         */
        abstract public function __toString();

        /**
         * @return resource|bool|null
         */
        abstract public function getResource();

        /**
         * @param resource $resource
         * @return static
         */
        abstract public function withResource(
            $resource
        );

        abstract public function open();

        abstract public function close();

        /**
         * @return null|resource
         */
        abstract public function detach();

        /**
         * @return int|null
         */
        abstract public function getSize();

        /**
         * @return int
         */
        abstract public function tell();

        /**
         * @return bool
         */
        abstract public function eof();

        /**
         * @return bool
         */
        abstract public function isSeekable();

        /**
         * @param int $offset
         * @param int $whence
         * @return mixed
         */
        abstract public function seek(
            $offset,
            $whence = SEEK_SET
        );

        /**
         * @return mixed
         */
        abstract public function rewind();

        /**
         * @return bool
         */
        abstract public function isWritable();

        /**
         * @param string $string
         * @return int
         */
        abstract public function write(
            $string
        );

        /**
         * @return bool
         */
        abstract public function isReadable();

        /**
         * @param int $length
         * @return string
         */
        abstract public function read(
            $length
        );

        /**
         * @return string
         */
        abstract public function getContents();

        /**
         * @param null|string $key
         * @return array|mixed|null
         */
        abstract public function getMetadata(
            $key = null
        );

        /**
         * @param string $name
         * @param resource|object|null $context
         * @return null|static
         */
        abstract public function rename(
            string $name,
            object $context = null
        );

        /**
         * @param int $size
         * @return bool
         */
        abstract public function truncate(
            int $size
        );

        /**
         * @return bool
         */
        abstract public function unlink();
    }
}