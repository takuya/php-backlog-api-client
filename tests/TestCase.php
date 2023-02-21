<?php

namespace tests;


use tests\assertions\PropertyAssertions;
use tests\assertions\ArrayAssertions;

abstract class TestCase extends \PHPUnit\Framework\TestCase {
  use PropertyAssertions;
  use ArrayAssertions;

}
