<?php

namespace XTrait\Stream {

    use Error;
    use Exception;
    use InvalidArgumentException;

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
         * StreamTrait constructor.
         * @param string $filename
         * @param string $mode
         */
        public function __construct(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN
        )
        {
            $this->filename = $filename;
            $this->mode = $mode;
        }

        /**
         * @return $this
         */
        public function open()
        {
            if (is_null($this->resource)) {
                if (is_null($this->filename)) {
                    $this->resource = tmpfile();
                } else {
                    $this->resource = fopen($this->filename, $this->mode);
                }
            }

            return $this;
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
         * @return static
         */
        public function withResource(
            $resource = null
        )
        {
            return (clone $this)
                ->setFilename(null)
                ->setMode(null)
                ->setResource($resource);
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
         * @inheritDoc
         */
        public function close()
        {
            $resource = $this->resource;

            if ($resource) {
                $uri = $this->getMetadata('uri');
                fclose($resource);

                if (!is_file($uri)) {
                    $this->setFilename(null);
                    $this->setMode(null);
                }
            }

            return $this->detach();
        }

        /**
         * @inheritDoc
         */
        public function detach()
        {
            $resource = $this->resource;

            if ($resource) {
                $this->resource = null;
            }

            return $resource;
        }

        /**
         * @inheritdoc
         */
        public function getSize()
        {
            $this->open();

            return is_null($this->resource)
                ? null
                : filesize($this->getUri());
        }

        /**
         * @inheritDoc
         */
        public function tell()
        {
            $this->open();

            return ftell($this->resource);
        }

        /**
         * @inheritdoc
         */
        public function eof()
        {
            $this->open();

            return !is_null($this->resource)
                && feof($this->resource);
        }

        /**
         * @inheritDoc
         */
        public function isSeekable()
        {
            $this->open();

            return !is_null($this->resource)
                && $this->getMetadata('seekable');
        }

        /**
         * @inheritdoc
         */
        public function seek(
            $offset,
            $whence = \SEEK_SET
        )
        {
            $this->open();

            return fseek($this->resource, $offset, $whence);
        }

        /**
         * @inheritdoc
         */
        public function rewind()
        {
            $this->open();

            rewind($this->resource);
        }

        /**
         * @inheritdoc
         */
        public function isWritable()
        {
            $this->open();
            $mode = $this->getMetadata('mode');

            return in_array($mode, FlagInterface::WRITABLES);
        }

        /**
         * @inheritDoc
         */
        public function write(
            $string
        )
        {
            $this->open();

            return fwrite($this->resource, $string);
        }

        /**
         * @inheritdoc
         */
        public function isReadable()
        {
            $this->open();
            $mode = $this->getMetadata('mode');

            return in_array($mode, FlagInterface::READABLES);
        }

        /**
         * @inheritDoc
         */
        public function read(
            $length
        )
        {
            $this->open();

            return fread($this->resource, $length);
        }

        /**
         * @return string|null
         */
        public function getUri()
        {
            $this->open();

            return $this->getMetadata('uri');
        }

        /**
         * @inheritDoc
         */
        public function getContents()
        {
            $this->open();

            return stream_get_contents($this->resource);
        }

        /**
         * @param null $key
         * @return array|mixed|null
         */
        public function getMetadata(
            $key = null
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
         * @return string
         */
        public function __toString()
        {
            /* @todo merge catches & composer php > 7.2 */
            try {
                return (string) @file_get_contents($this->getUri());
            } catch (Error $e) {}
            catch (Exception $e) {}

            return '';
        }

        /**
         * @param int $size
         * @return bool
         */
        public function truncate(
            int $size
        )
        {
            $this->open();

            return ftruncate($this->resource, $size);
        }

        /**
         * @return bool
         */
        public function unlink()
        {
            $uri = $this->filename;

            if ($this->resource) {
                $uri = $this->getMetadata('uri');
                $this->close();
            }

            if (strlen($uri)) {
                return unlink($uri);
            }

            return false;
        }
    }
}