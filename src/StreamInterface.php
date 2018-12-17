<?php

namespace XTrait\Stream {

    use RuntimeException;

    /**
     * Describes a late data stream, INSPIRED on the PSR's StreamInterface.
     *
     * @see \Psr\Http\Message\StreamInterface
     *
     * Typically, an instance of StreamInterface which doesn't requires an already
     * opened resource.
     *
     * It SHOULD be used in place of an simple StreamInterface to get an instance
     * (e.g. for an UploadedFileInterface), where the file is broken for any
     * reason, or just to avoid to open some files which aren't really used.
     *
     * Each method MUST return the stream itself and provide the return value as a
     * reference.
     */
    interface StreamInterface
    {
        /**
         * Reads all data from the stream into a string, from the beginning to end.
         *
         * This method MUST attempt to seek to the beginning of the stream before
         * reading data and read the stream until the end is reached.
         *
         * Warning: This could attempt to load a large amount of data into memory.
         *
         * This method MUST NOT raise an exception in order to conform with PHP's
         * string casting operations.
         *
         * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
         * @return string
         */
        public function __toString();

        /**
         * Creates a new instance, using the specified resource
         *
         * @param resource|object $resource
         * @return static
         */
        public function withResource(
            object $resource
        );

        /**
         * @param string $filename
         * @param string $mode
         * @param bool $useIncludePath
         * @param object|null $context
         * @return static|StreamInterface
         */
        public function withFilename(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN,
            bool $useIncludePath = false,
            object $context = null
        ): StreamInterface;

        /**
         * Returns the resource
         *
         * It opens the stream, if needed and if it returns false, consider the
         * stream as detached
         *
         * @return resource|bool|null
         */
        public function getResource();

        /**
         * Returns the resource uri
         *
         * @return null|string
         */
        public function getUri(): ?string;

        /**
         * Opens the stream
         *
         * @return $this
         */
        public function open(): self;

        /**
         * Closes the stream and any underlying resources.
         *
         * @return $this
         */
        public function close(): self;

        /**
         * Separates any underlying resources from the stream.
         *
         * After the stream has been detached, the stream is in an unusable state.
         *
         * @return resource|null Underlying PHP stream, if any
         */
        public function detach();

        /**
         * Get the size of the stream if known.
         *
         * @return int|null Returns the size in bytes if known, or null if unknown.
         */
        public function getSize();

        /**
         * Returns the current position of the file read/write pointer
         *
         * @return int Position of the file pointer
         * @throws RuntimeException on error.
         */
        public function tell();

        /**
         * Returns true if the stream is at the end of the stream.
         *
         * @return bool
         */
        public function eof();

        /**
         * Returns whether or not the stream is seekable.
         *
         * @return bool
         */
        public function isSeekable();

        /**
         * Seek to a position in the stream.
         *
         * @link http://www.php.net/manual/en/function.fseek.php
         * @param int $offset Stream offset
         * @param int $whence Specifies how the cursor position will be calculated
         *     based on the seek offset. Valid values are identical to the built-in
         *     PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to
         *     offset bytes SEEK_CUR: Set position to current location plus offset
         *     SEEK_END: Set position to end-of-stream plus offset.
         * @param bool|null &$success
         * @return $this
         * @throws RuntimeException on failure.
         */
        public function seek(
            int $offset,
            int $whence = SEEK_SET,
            bool &$success = null
        ): self;

        /**
         * Seek to the beginning of the stream.
         *
         * If the stream is not seekable, this method will raise an exception;
         * otherwise, it will perform a seek(0).
         *
         * @see seek()
         * @link http://www.php.net/manual/en/function.fseek.php
         * @param bool|null &$success
         * @return $this
         * @throws RuntimeException on failure.
         */
        public function rewind(
            bool &$success = null
        ): self;

        /**
         * Returns whether or not the stream is writable.
         *
         * @return bool
         */
        public function isWritable();

        /**
         * Write data to the stream.
         *
         * @param string $string The string that is to be written.
         * @param int|null &$written Provides the number of bytes written to the stream.
         * @return $this
         * @throws RuntimeException on failure.
         */
        public function write(
            string $string,
            int &$written = null
        ): self;

        /**
         * Returns whether or not the stream is readable.
         *
         * @return bool
         */
        public function isReadable();

        /**
         * Read data from the stream.
         *
         * @param int $length Read up to $length bytes from the object and return
         *     them. Fewer than $length bytes may be returned if underlying stream
         *     call returns fewer bytes.
         * @return string Returns the data read from the stream, or an empty string
         *     if no bytes are available.
         * @throws RuntimeException if an error occurs.
         */
        public function read(
            int $length
        ): string;

        /**
         * Returns the remaining contents in a string
         *
         * @return string
         * @throws RuntimeException if unable to read or an error occurs while
         *     reading.
         */
        public function getContents(): string;

        /**
         * Get stream metadata as an associative array or retrieve a specific key.
         *
         * The keys returned are identical to the keys returned from PHP's
         * stream_get_meta_data() function.
         *
         * @link http://php.net/manual/en/function.stream-get-meta-data.php
         * @param string $key Specific metadata to retrieve.
         * @return array|mixed|null Returns an associative array if no key is
         *     provided. Returns a specific key value if a key is provided and the
         *     value is found, or null if the key is not found.
         */
        public function getMetadata(
            string $key = null
        );

        /**
         * Copies the resource and return a new stream for the specified
         * target
         *
         * @param string $target
         * @param resource|object|null $context
         * @param StreamInterface|null &$newStream
         * @return $this
         * @throws RuntimeException if unable to copy or an error occurs while
         *     copying.
         */
        public function copy(
            string $target,
            object $context = null,
            StreamInterface &$newStream = null
        ): self;

        /**
         * Renames the resource and provides a new stream for the specified
         * target
         *
         * @param string $target
         * @param resource|object|null $context
         * @param StreamInterface|null &$newStream
         * @return $this
         * @throws RuntimeException if unable to rename or an error occurs while
         *     renaming.
         */
        public function rename(
            string $target,
            object $context = null,
            StreamInterface &$newStream = null
        ): self;

        /**
         * Truncates the resource and provides the result
         *
         * @param int $size
         * @param bool|null &$success
         * @return $this
         * @throws RuntimeException if unable to truncate or an error occurs while
         *     truncating.
         */
        public function truncate(
            int $size = 0,
            bool &$success = null
        ): self;

        /**
         * Unlinks the resource and provides the result
         *
         * @param bool|null &$success
         * @return $this
         * @throws RuntimeException if unable to unlink or an error occurs while
         *     unlinking.
         */
        public function unlink(
            bool &$success = null
        ): self;
    }
}