<?php

namespace XTrait\Stream\Factory {

    use XTrait\Common;
    use XTrait\Stream;
    use XTrait\Stream\StreamInterface;
    use XTrait\Stream\FlagInterface;
    use Psr\Http\Message\StreamInterface as PsrStreamInterface;

    trait FactoryTrait
    {
        use AbstractTrait;
        use Common\FactoryTrait;

        /**
         * @param string $content
         * @return StreamInterface|PsrStreamInterface
         */
        public function createStream(
            string $content = ''
        ): PsrStreamInterface
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
         * @return StreamInterface|PsrStreamInterface
         */
        public function createStreamFromFile(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN,
            bool $useIncludePath = false,
            object $context = null
        ): PsrStreamInterface
        {
            return new Stream($filename, $mode, $useIncludePath, $context);
        }

        /**
         * @param $resource
         * @return StreamInterface|PsrStreamInterface
         */
        public function createStreamFromResource(
            $resource
        ): PsrStreamInterface
        {
            return $this->createStreamFromFile('')
                ->withResource($resource);
        }
    }
}