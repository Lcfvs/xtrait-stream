<?php

namespace XTrait\Stream\Factory {

    use XTrait\Common;
    use XTrait\Stream;
    use XTrait\Stream\StreamInterface;
    use XTrait\Stream\FlagInterface;

    trait FactoryTrait
    {
        use AbstractTrait;
        use Common\FactoryTrait;

        /**
         * @param string $content
         * @return StreamInterface
         */
        public function createStream(
            string $content = ''
        ): StreamInterface
        {
            $stream = $this->createStreamFromResource(tmpfile());
            $stream->write($content);

            return $stream;
        }

        /**
         * @param string $filename
         * @param string $mode
         * @param bool $useIncludePath
         * @param resource|object|null $context
         * @return StreamInterface
         */
        public function createStreamFromFile(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN,
            bool $useIncludePath = false,
            object $context = null
        ): StreamInterface
        {
            return new Stream($filename, $mode, $useIncludePath, $context);
        }

        /**
         * @param $resource
         * @return StreamInterface
         */
        public function createStreamFromResource(
            $resource
        ): StreamInterface
        {
            return $this->createStreamFromFile('')
                ->withResource($resource);
        }
    }
}