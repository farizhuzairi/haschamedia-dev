<?php

namespace HaschaDev\Services\Page;

enum Routerable : string
{
    case INDEX = "index";
    case LOGIN = "login";
    case REGISTER = "register";
    case LOGOUT = "logout";
    case DASHBOARD = "dashboard";
    case PRODUCT = "product";
    case PRODUCT_CREATE = "product.create";
    case PRODUCT_MANAGE = "product.manage";
    case MODEL = "model";
    case MODEL_MANAGE = "model.manage";
    case FEATURE = "feature";
    case FEATURE_CREATE = "feature.create";
    case FEATURE_MANAGE = "feature.manage";
    case RULE = "rule";
    case RULE_CREATE = "rule.create";
    case RULE_MANAGE = "rule.manage";
    // case SERVICE = "service";
    case SERVICE_CREATE = "service.create";
    case SERVICE_MANAGE = "service.manage";
    case SERVICE_PAGE_CREATE = "service.page.create";
    case SERVICE_PAGE_MANAGE = "service.page.manage";
    case PACKAGE = "package";
    case PACKAGE_CREATE = "package.create";
    case PACKAGE_MANAGE = "package.manage";
    case INTEGRATION = "integration";

    case LIVEWIRE = "livewire.update";
    case LIVEWIRE_FILE = "livewire.upload";

    public static function init(string $routeName): ?self
    {
        return self::tryFrom($routeName);
    }

    public function url(...$params): string
    {
        if(!empty($params)){
            return route($this->value, $params);
        }
        return route($this->value);
    }
}