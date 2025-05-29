<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Architecture\Injector\RepositoryInjector::class,
    App\Architecture\Injector\ServicesInjector::class,
    App\Architecture\Injector\ResponderInjector::class,
];
