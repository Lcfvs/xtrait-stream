<?php

namespace XTrait {

    use XTrait\Stream\FlagInterface;
    use XTrait\Stream\LateStreamInterface;
    use XTrait\Stream\StreamTrait;

    class Stream
        implements
            FlagInterface,
            LateStreamInterface
    {
        use StreamTrait;
    }
}