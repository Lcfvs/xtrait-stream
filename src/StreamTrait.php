<?php

namespace XTrait\Stream {

    use InvalidArgumentException;
    use RuntimeException;
    use Throwable;

    trait StreamTrait
    {
        /**
         * @var resource|bool|null $resource
         */
        private $resource;

        /**
         * @var string|null $filename
         */
        private $filename;

        /**
         * @var string|null $mode
         */
        private $mode;

        /**
         * @var bool $useIncludePath
         */
        private $useIncludePath = false;

        /**
         * @var resource $context
         */
        private $context;

        /**
         * @return string
         */
        public function __toString()
        {
            try {
                return (string) @file_get_contents($this->getUri());
            } catch (Throwable $e) {}

            return '';
        }

        /**
         * @return bool|null|resource
         */
        public function getResource()
        {
            return $this->resource;
        }

        /**
         * @param bool|null|resource $resource
         * @return static|StreamInterface
         */
        public function withResource(
            $resource = null
        ): StreamInterface
        {
            return (clone $this)
                ->setContext(null)
                ->setFilename(null)
                ->setMode(null)
                ->setResource($resource)
                ->setUseIncludePath(false);
        }

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
        ): StreamInterface
        {
            return (clone $this)
                ->setContext($context)
                ->setFilename($filename)
                ->setMode($mode)
                ->setResource(null)
                ->setUseIncludePath($useIncludePath);
        }

        /**
         * @return null|string
         */
        public function getUri(): ?string
        {
            if ($this->resource) {
                return $this->getMetadata('uri');
            }

            return $this->filename;
        }

        /**
         * @return $this|StreamInterface
         */
        public function open(): StreamInterface
        {
            if (is_null($this->resource)) {
                if (is_null($this->filename)) {
                    $resource = tmpfile();
                } else {
                    $uri = $this->filename;
                    $mode = $this->mode;
                    $include = $this->useIncludePath;
                    $context = $this->context;

                    if ($context) {
                        $resource = fopen($uri, $mode, $include, $context);
                    } else {
                        $resource = fopen($uri, $mode, $include);
                    }
                }

                $this->resource = $resource;
            }

            return $this;
        }

        /**
         * @return $this|StreamInterface
         */
        public function close(): StreamInterface
        {
            $resource = $this->resource;

            if ($resource) {
                $uri = $this->getUri();
                fclose($resource);

                if (strlen($uri) && !is_file($uri)) {
                    $this->setContext(null);
                    $this->setFilename(null);
                    $this->setMode(null);
                    $this->setUseIncludePath(null);
                }
            }

            $this->detach();

            return $this;
        }

        /**
         * @return resource|bool|null
         */
        public function detach()
        {
            $resource = $this->resource;

            if ($resource) {
                $this->setResource(null);
            }

            return $resource;
        }

        /**
         * @return int|null
         */
        public function getSize()
        {
            $this->open();

            return is_null($this->resource)
                ? null
                : filesize($this->getUri());
        }

        /**
         * @return int
         * @throws RuntimeException
         */
        public function tell()
        {
            $this->open();

            return ftell($this->resource);
        }

        /**
         * @return bool
         */
        public function eof()
        {
            $this->open();

            return !is_null($this->resource)
                && feof($this->resource);
        }

        /**
         * @return bool
         */
        public function isSeekable()
        {
            $this->open();

            return !is_null($this->resource)
                && $this->getMetadata('seekable');
        }

        /**
         * @param int $offset
         * @param int $whence
         * @param bool|null &$success
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        public function seek(
            $offset,
            $whence = \SEEK_SET,
            bool &$success = null
        ): StreamInterface
        {
            if (!$this->isSeekable()) {
                throw new RuntimeException('Unable to seek');
            }

            $success = fseek($this->resource, $offset, $whence) !== -1;

            return $this;
        }

        /**
         * @param bool|null &$success
         * @return $this|StreamInterface
         * @throws RuntimeException on failure.
         */
        public function rewind(
            bool &$success = null
        ): StreamInterface
        {
            $this->open();

            $success = rewind($this->resource);

            return $this;
        }

        /**
         * @return bool
         */
        public function isWritable()
        {
            $this->open();
            $mode = $this->getMetadata('mode');

            return in_array($mode, FlagInterface::WRITABLES);
        }

        /**
         * @param string $string
         * @param int|null
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        public function write(
            string $string,
            int &$written = null
        ): StreamInterface
        {
            $this->open();

            $written = fwrite($this->resource, $string);

            return $this;
        }

        /**
         * @return bool
         */
        public function isReadable()
        {
            $this->open();
            $mode = $this->getMetadata('mode');

            return in_array($mode, FlagInterface::READABLES);
        }

        /**
         * @param int $length
         * @return string
         * @throws RuntimeException
         */
        public function read(
            int $length
        ): string
        {
            $this->open();

            return fread($this->resource, $length);
        }

        /**
         * @return string
         * @throws RuntimeException
         */
        public function getContents(): string
        {
            $this->open();

            return stream_get_contents($this->resource);
        }

        /**
         * @param string $key
         * @return array|mixed|null
         */
        public function getMetadata(
            string $key = null
        )
        {
            $this->open();
            $data = stream_get_meta_data($this->resource);

            if (is_null($key)) {
                return $data;
            }

            return $data[$key] ?? null;
        }

        /**
         * @param string $target
         * @param resource|object|null $context
         * @param StreamInterface|null &$newStream
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        public function copy(
            string $target,
            object $context = null,
            StreamInterface &$newStream = null
        ): StreamInterface
        {
            $uri = $this->getUri();

            if (strlen($uri)) {
                if ($context) {
                    $result = copy($uri, $target, $context);
                } else {
                    $result = copy($uri, $target);
                }

                if ($result) {
                    $newStream = (clone $this)
                        ->setResource(null)
                        ->setFilename($target)
                        ->setMode($this->mode)
                        ->setContext($context);
                }
            }

            return $this;
        }

        /**
         * @param string $target
         * @param resource|object|null $context
         * @param StreamInterface|null &$newStream
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        public function rename(
            string $target,
            object $context = null,
            StreamInterface &$newStream = null
        ): StreamInterface
        {
            $uri = $this->getUri();

            if (strlen($uri)) {
                if ($context) {
                    $result = rename($uri, $target, $context);
                } else {
                    $result = rename($uri, $target);
                }

                if ($result) {
                    $this->close();

                    $newStream = (clone $this)
                        ->setResource(null)
                        ->setFilename($target)
                        ->setMode($this->mode)
                        ->setContext($context);
                }
            }

            return $this;
        }

        /**
         * @param int $size
         * @param bool|null &$success
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        public function truncate(
            int $size = 0,
            bool &$success = null
        ): StreamInterface
        {
            $this->open();

            $success = ftruncate($this->resource, $size);

            return $this;
        }

        /**
         * @param bool|null &$success
         * @return $this|StreamInterface
         * @throws RuntimeException
         */
        public function unlink(
            bool &$success = null
        ): StreamInterface
        {
            $uri = $this->getUri();
            $success = false;

            if ($this->resource) {
                $this->close();
            }

            if (strlen($uri)) {
                $success = unlink($uri);
            }

            return $this;
        }

        /**
         * @param bool|null|resource $resource
         * @return $this
         * @throws InvalidArgumentException
         */
        private function setResource(
            $resource
        )
        {
            if (!is_resource($resource) && !in_array($resource, [null, false])) {
                throw new InvalidArgumentException('Invalid resource');
            }

            $this->resource = $resource;

            return $this;
        }

        /**
         * @param string|null $filename
         * @return $this
         */
        private function setFilename(
            string $filename = null
        )
        {
            $this->filename = $filename;

            return $this;
        }

        /**
         * @param string|null $mode
         * @return $this
         */
        private function setMode(
            string $mode = null
        )
        {
            $this->mode = $mode;

            return $this;
        }

        /**
         * @param bool $useIncludePath
         * @return $this
         */
        private function setUseIncludePath(
            bool $useIncludePath = false
        )
        {
            $this->useIncludePath = $useIncludePath;

            return $this;
        }

        /**
         * @param resource|object|null $context
         * @return $this
         */
        private function setContext(
            object $context = null
        )
        {
            $this->context = $context;

            return $this;
        }
    }
}