<?php

namespace XTrait\Stream\Factory {

    use XTrait\Common;
    use XTrait\Stream;
    use XTrait\Stream\FlagInterface;
    use Psr\Http\Message\StreamInterface;

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
         * @return StreamInterface
         */
        public function createStreamFromFile(
            string $filename,
            string $mode =  FlagInterface::FLAG_R_BOF_BIN
        ): StreamInterface
        {
            $resource = fopen($filename, $mode) ?: null;

            return $this->createStreamFromResource($resource);
        }

        /**
         * @param $resource
         * @return StreamInterface
         */
        public function createStreamFromResource(
            $resource
        ): StreamInterface
        {
            return (new Stream(''))
                ->withResource($resource);
        }
    }
}