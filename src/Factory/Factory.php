<?php

namespace XTrait\Stream {

    use XTrait\Stream\Factory\FactoryInterface;
    use XTrait\Stream\Factory\FactoryTrait;

    class Factory implements
        FactoryInterface
    {
        use FactoryTrait;
    }
}