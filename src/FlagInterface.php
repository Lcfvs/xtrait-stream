<?php

namespace XTrait\Stream {

    interface FlagInterface
        extends
            MODEInterface
    {
        const FLAG_R_BOF = 'r';
        const FLAG_RW_BOF = 'r+';
        const FLAG_W_EMPTY = 'w';
        const FLAG_RW_EMPTY = 'w+';
        const FLAG_W_EOF = 'a';
        const FLAG_RW_EOF = 'a+';
        const FLAG_W_EXCL = 'x';
        const FLAG_RW_EXCL = 'x+';
        const FLAG_W_CREATE = 'c';
        const FLAG_RW_CREATE = 'c+';
        const FLAG_CLOSE_ON_EXEC = 'e';
        
        const FLAG_R_BOF_BIN = self::FLAG_R_BOF . self::MODE_BIN;
        const FLAG_RW_BOF_BIN = self::FLAG_RW_BOF . self::MODE_BIN;
        const FLAG_W_EMPTY_BIN = self::FLAG_W_EMPTY . self::MODE_BIN;
        const FLAG_RW_EMPTY_BIN = self::FLAG_RW_EMPTY . self::MODE_BIN;
        const FLAG_W_EOF_BIN = self::FLAG_W_EOF . self::MODE_BIN;
        const FLAG_RW_EOF_BIN = self::FLAG_RW_EOF . self::MODE_BIN;
        const FLAG_W_EXCL_BIN = self::FLAG_W_EXCL . self::MODE_BIN;
        const FLAG_RW_EXCL_BIN = self::FLAG_RW_EXCL . self::MODE_BIN;
        const FLAG_W_CREATE_BIN = self::FLAG_W_CREATE . self::MODE_BIN;
        const FLAG_RW_CREATE_BIN = self::FLAG_RW_CREATE . self::MODE_BIN;
        const FLAG_CLOSE_ON_EXEC_BIN = self::FLAG_CLOSE_ON_EXEC . self::MODE_BIN;
        
        const FLAG_R_BOF_TXT = self::FLAG_R_BOF . self::MODE_TXT;
        const FLAG_RW_BOF_TXT = self::FLAG_RW_BOF . self::MODE_TXT;
        const FLAG_W_EMPTY_TXT = self::FLAG_W_EMPTY . self::MODE_TXT;
        const FLAG_RW_EMPTY_TXT = self::FLAG_RW_EMPTY . self::MODE_TXT;
        const FLAG_W_EOF_TXT = self::FLAG_W_EOF . self::MODE_TXT;
        const FLAG_RW_EOF_TXT = self::FLAG_RW_EOF . self::MODE_TXT;
        const FLAG_W_EXCL_TXT = self::FLAG_W_EXCL . self::MODE_TXT;
        const FLAG_RW_EXCL_TXT = self::FLAG_RW_EXCL . self::MODE_TXT;
        const FLAG_W_CREATE_TXT = self::FLAG_W_CREATE . self::MODE_TXT;
        const FLAG_RW_CREATE_TXT = self::FLAG_RW_CREATE . self::MODE_TXT;
        const FLAG_CLOSE_ON_EXEC_TXT = self::FLAG_CLOSE_ON_EXEC . self::MODE_TXT;

        const FLAGS = [
            self::FLAG_R_BOF,
            self::FLAG_RW_BOF,
            self::FLAG_W_EMPTY,
            self::FLAG_RW_EMPTY,
            self::FLAG_W_EOF,
            self::FLAG_RW_EOF,
            self::FLAG_W_EXCL,
            self::FLAG_RW_EXCL,
            self::FLAG_W_CREATE,
            self::FLAG_RW_CREATE,
            self::FLAG_CLOSE_ON_EXEC,
            self::FLAG_R_BOF_BIN,
            self::FLAG_RW_BOF_BIN,
            self::FLAG_W_EMPTY_BIN,
            self::FLAG_RW_EMPTY_BIN,
            self::FLAG_W_EOF_BIN,
            self::FLAG_RW_EOF_BIN,
            self::FLAG_W_EXCL_BIN,
            self::FLAG_RW_EXCL_BIN,
            self::FLAG_W_CREATE_BIN,
            self::FLAG_RW_CREATE_BIN,
            self::FLAG_CLOSE_ON_EXEC_BIN,
            self::FLAG_R_BOF_TXT,
            self::FLAG_RW_BOF_TXT,
            self::FLAG_W_EMPTY_TXT,
            self::FLAG_RW_EMPTY_TXT,
            self::FLAG_W_EOF_TXT,
            self::FLAG_RW_EOF_TXT,
            self::FLAG_W_EXCL_TXT,
            self::FLAG_RW_EXCL_TXT,
            self::FLAG_W_CREATE_TXT,
            self::FLAG_RW_CREATE_TXT,
            self::FLAG_CLOSE_ON_EXEC_TXT
        ];

        const READABLES = [
            self::FLAG_R_BOF,
            self::FLAG_RW_BOF,
            self::FLAG_RW_EMPTY,
            self::FLAG_RW_EOF,
            self::FLAG_RW_EXCL,
            self::FLAG_RW_CREATE,
            self::FLAG_R_BOF_BIN,
            self::FLAG_RW_BOF_BIN,
            self::FLAG_RW_EMPTY_BIN,
            self::FLAG_RW_EOF_BIN,
            self::FLAG_RW_EXCL_BIN,
            self::FLAG_RW_CREATE_BIN,
            self::FLAG_R_BOF_TXT,
            self::FLAG_RW_BOF_TXT,
            self::FLAG_RW_EMPTY_TXT,
            self::FLAG_RW_EOF_TXT,
            self::FLAG_RW_EXCL_TXT,
            self::FLAG_RW_CREATE_TXT
        ];

        const WRITABLES = [
            self::FLAG_RW_BOF,
            self::FLAG_W_EMPTY,
            self::FLAG_RW_EMPTY,
            self::FLAG_RW_EOF,
            self::FLAG_RW_EXCL,
            self::FLAG_RW_CREATE,
            self::FLAG_RW_BOF_BIN,
            self::FLAG_W_EMPTY_BIN,
            self::FLAG_RW_EMPTY_BIN,
            self::FLAG_RW_EOF_BIN,
            self::FLAG_RW_EXCL_BIN,
            self::FLAG_RW_CREATE_BIN,
            self::FLAG_RW_BOF_TXT,
            self::FLAG_W_EMPTY_TXT,
            self::FLAG_RW_EMPTY_TXT,
            self::FLAG_RW_EOF_TXT,
            self::FLAG_RW_EXCL_TXT,
            self::FLAG_RW_CREATE_TXT
        ];

        const READABLES_AND_WRITABLES = [
            self::FLAG_RW_BOF,
            self::FLAG_RW_EMPTY,
            self::FLAG_RW_EOF,
            self::FLAG_RW_EXCL,
            self::FLAG_RW_CREATE,
            self::FLAG_RW_BOF_BIN,
            self::FLAG_RW_EMPTY_BIN,
            self::FLAG_RW_EOF_BIN,
            self::FLAG_RW_EXCL_BIN,
            self::FLAG_RW_CREATE_BIN,
            self::FLAG_RW_BOF_TXT,
            self::FLAG_RW_EMPTY_TXT,
            self::FLAG_RW_EOF_TXT,
            self::FLAG_RW_EXCL_TXT,
            self::FLAG_RW_CREATE_TXT
        ];
    }
}