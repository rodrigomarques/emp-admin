<?php

namespace App\Models;

abstract class File {
    const VALID_EXT = ["jpg", "jpeg", "png", "pdf"];
    const LIMIT_SIZE = 1024 * 1024 * 2;
}
