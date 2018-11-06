<?php

namespace XTrait\Stream {

    use RuntimeException;

    trait AbstractTrait
    {
        /**
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
         * @param resource|object $resource
         * @return StreamInterface
         */
        abstract public function withResource(
            object $resource
        ): StreamInterface;

        /**
         * @return resource|bool|null
         */
        abstract public function getResource();

        /**
         * @return null|string
         */
        abstract public function getUri(): ?string;

        /**
         * @return $this|StreamInterface
         */
        abstract public function open(): StreamInterface;

        /**
         * @return $this|StreamInterface
         */
        abstract public function close(): StreamInterface;

        /**
         * @return resource|null
         */
        abstract public function detach();

        /**
         * @return int|null
         */
        abstract public function getSize();

        /**
         * @return int
         * @throws RuntimeException
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
         * @param bool|null &$success
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        abstract public function seek(
            int $offset,
            int $whence = SEEK_SET,
            bool &$success = null
        ): StreamInterface;

        /**
         * @param bool|null &$success
         * @return $this|StreamInterface
         * @throws RuntimeException on failure.
         */
        abstract public function rewind(
            bool &$success = null
        ): StreamInterface;

        /**
         * @return bool
         */
        abstract public function isWritable();

        /**
         * @param string $string
         * @param int|null
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        abstract public function write(
            string $string,
            int &$written = null
        ): StreamInterface;

        /**
         * @return bool
         */
        abstract public function isReadable();

        /**
         * @param int $length
         * @return string
         * @throws RuntimeException
         */
        abstract public function read(
            int $length
        ): string;

        /**
         * @return string
         * @throws RuntimeException
         */
        abstract public function getContents(): string;

        /**
         * @param string $key
         * @return array|mixed|null
         */
        abstract public function getMetadata(
            string $key = null
        );

        /**
         * @param string $target
         * @param resource|object|null $context
         * @param StreamInterface|null &$newStream
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        abstract public function copy(
            string $target,
            object $context = null,
            StreamInterface &$newStream = null
        ): StreamInterface;

        /**
         * @param string $target
         * @param resource|object|null $context
         * @param StreamInterface|null &$newStream
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        abstract public function rename(
            string $target,
            object $context = null,
            StreamInterface &$newStream = null
        ): StreamInterface;

        /**
         * @param int $size
         * @param bool|null &$success
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        abstract public function truncate(
            int $size,
            bool &$success = null
        ): StreamInterface;

        /**
         * @param bool|null &$success
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        abstract public function unlink(
            bool &$success = null
        ): StreamInterface;
    }
}