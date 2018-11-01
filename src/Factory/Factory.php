<?php

namespace XTrait\Stream {

    use XTrait\Stream\Factory\FactoryTrait;
    use Psr\Http\Message\StreamFactoryInterface;

    class Factory
        implements StreamFactoryInterface
    {
        use FactoryTrait;
    }
}