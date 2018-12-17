<?php

namespace XTrait\Stream\Factory {

    use XTrait\Common;
    use XTrait\Stream\FlagInterface;
    use XTrait\Stream\StreamInterface;
    use XTrait\Stream\StreamTrait;

    trait FactoryTrait
    {
        use Common\FactoryTrait;

        /**
         * @param string $content
         * @return StreamInterface
         */
        public static function createStream(
            string $content = ''
        ): StreamInterface
        {
            $stream = static::createStreamFromResource(tmpfile());
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
        public static function createStreamFromFile(
            string $filename,
            string $mode = FlagInterface::FLAG_R_BOF_BIN,
            bool $useIncludePath = false,
            object $context = null
        ): StreamInterface
        {
            $stream = new class() implements
                StreamInterface
            {
                use StreamTrait;
            };

            return $stream->withFilename(
                $filename,
                $mode,
                $useIncludePath,
                $context
            );
        }

        /**
         * @param resource|object $resource
         * @return StreamInterface
         */
        public static function createStreamFromResource(
            object $resource
        ): StreamInterface
        {
            $stream = new class() implements
                StreamInterface
            {
                use StreamTrait;
            };

            return $stream->withResource($resource);
        }
    }
}