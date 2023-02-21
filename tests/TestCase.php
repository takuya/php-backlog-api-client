<?php

namespace Tests;


use Tests\assertions\PropertyAssertions;
use Tests\assertions\ArrayAssertions;

abstract class TestCase extends \PHPUnit\Framework\TestCase {
  use PropertyAssertions;
  use ArrayAssertions;

}
