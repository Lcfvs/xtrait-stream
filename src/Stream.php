<?php

namespace XTrait {

    use XTrait\Stream\StreamInterface;
    use XTrait\Stream\StreamTrait;

    class Stream implements
        StreamInterface
    {
        use StreamTrait;
    }
}