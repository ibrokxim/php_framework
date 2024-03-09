<?php

namespace Ibrohim\Framework\Routing;

use Ibrohim\Framework\Http\Request;

interface RouterInterface
{
     public function dispatch(Request $request);
}