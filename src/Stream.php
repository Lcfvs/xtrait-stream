<?php

namespace XTrait {

    use XTrait\Stream\FlagInterface;
    use XTrait\Stream\StreamInterface;
    use XTrait\Stream\StreamTrait;

    class Stream
        implements
            FlagInterface,
            StreamInterface
    {
        use StreamTrait;
    }
}