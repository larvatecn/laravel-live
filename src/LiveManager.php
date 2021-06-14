<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 */

namespace Larva\Live;

use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Larva\Live\Providers\AbstractProvider;

/**
 * 直播管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LiveManager extends Manager implements Contracts\Factory
{
    /**
     * Get a driver instance.
     *
     * @param string $driver
     * @return AbstractProvider
     */
    public function with(string $driver)
    {
        return $this->driver($driver);
    }

    /**
     * Build an GeoIP provider instance.
     *
     * @param string $provider
     * @param array $config
     * @return Providers\AbstractProvider
     */
    public function buildProvider(string $provider, array $config)
    {
        return new $provider($this->container['request'],
            Arr::get($config, 'key', ''),
            Arr::get($config, 'guzzle', [])
        );
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('live.default');
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return Providers\AbstractProvider
     */
    protected function createAliyunDriver()
    {
        $config = $this->config->get("live.drivers.aliyun", []);
        return $this->buildProvider(
            Providers\AliyunProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return Providers\AbstractProvider
     */
    protected function createTencentDriver()
    {
        $config = $this->config->get("live.drivers.tencent", []);
        return $this->buildProvider(
            Providers\TencentProvider::class, $config
        );
    }

}