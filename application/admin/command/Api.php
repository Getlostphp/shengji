<?php

namespace app\admin\command;

use app\admin\command\Api\library\Builder;
use think\Config;
use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use think\Exception;

class Api extends Command
{
    protected function configure()
    {
        $site = Config::get('site');
        $this
            ->setName('api')
            ->addOption('url', 'u', Option::VALUE_OPTIONAL, 'default api url', '')
            ->addOption('module', 'm', Option::VALUE_OPTIONAL, 'module name(admin/index/api)', 'api')
            ->addOption('output', 'o', Option::VALUE_OPTIONAL, 'output index file name', 'api.html')
            ->addOption('template', 'e', Option::VALUE_OPTIONAL, '', 'index.html')
            ->addOption('force', 'f', Option::VALUE_OPTIONAL, 'force override general file', false)
            ->addOption('title', 't', Option::VALUE_OPTIONAL, 'document title', $site['name'])
<<<<<<< HEAD
<<<<<<< HEAD
            ->addOption('class', 'c', Option::VALUE_OPTIONAL | Option::VALUE_IS_ARRAY, 'extend class', null)
            ->addOption('language', 'l', Option::VALUE_OPTIONAL, 'language', 'zh-cn')
            ->addOption('addon', 'a', Option::VALUE_OPTIONAL, 'addon name', null)
=======
            ->addOption('author', 'a', Option::VALUE_OPTIONAL, 'document author', $site['name'])
            ->addOption('class', 'c', Option::VALUE_OPTIONAL | Option::VALUE_IS_ARRAY, 'extend class', null)
            ->addOption('language', 'l', Option::VALUE_OPTIONAL, 'language', 'zh-cn')
>>>>>>> fastadmin/master
=======
            ->addOption('author', 'a', Option::VALUE_OPTIONAL, 'document author', $site['name'])
            ->addOption('class', 'c', Option::VALUE_OPTIONAL | Option::VALUE_IS_ARRAY, 'extend class', null)
            ->addOption('language', 'l', Option::VALUE_OPTIONAL, 'language', 'zh-cn')
>>>>>>> fastadmin/master
            ->addOption('controller', 'r', Option::VALUE_REQUIRED | Option::VALUE_IS_ARRAY, 'controller name', null)
            ->setDescription('Build Api document from controller');
    }

    protected function execute(Input $input, Output $output)
    {
        $apiDir = __DIR__ . DS . 'Api' . DS;

        $force = $input->getOption('force');
        $url = $input->getOption('url');
        $language = $input->getOption('language');
<<<<<<< HEAD
<<<<<<< HEAD
        $template = $input->getOption('template');
        if (!preg_match("/^([a-z0-9]+)\.html\$/i", $template)) {
            throw new Exception('template file not correct');
        }
=======
>>>>>>> fastadmin/master
=======
>>>>>>> fastadmin/master
        $language = $language ? $language : 'zh-cn';
        $langFile = $apiDir . 'lang' . DS . $language . '.php';
        if (!is_file($langFile)) {
            throw new Exception('language file not found');
        }
        $lang = include_once $langFile;
        // ????????????
        $output_dir = ROOT_PATH . 'public' . DS;
        $output_file = $output_dir . $input->getOption('output');
        if (is_file($output_file) && !$force) {
            throw new Exception("api index file already exists!\nIf you need to rebuild again, use the parameter --force=true ");
        }
        // ????????????
        $template_dir = $apiDir . 'template' . DS;
<<<<<<< HEAD
<<<<<<< HEAD
        $template_file = $template_dir . $template;
=======
        $template_file = $template_dir . $input->getOption('template');
>>>>>>> fastadmin/master
=======
        $template_file = $template_dir . $input->getOption('template');
>>>>>>> fastadmin/master
        if (!is_file($template_file)) {
            throw new Exception('template file not found');
        }
        // ????????????
        $classes = $input->getOption('class');
        // ??????
        $title = $input->getOption('title');
<<<<<<< HEAD
<<<<<<< HEAD
        // ??????
        $module = $input->getOption('module');
        // ??????
        $addon = $input->getOption('addon');

        $moduleDir = $addonDir = '';
        if ($addon) {
            $addonInfo = get_addon_info($addon);
            if (!$addonInfo) {
                throw new Exception('addon not found');
            }
            $moduleDir = ADDON_PATH . $addon . DS;
        } else {
            $moduleDir = APP_PATH . $module . DS;
        }
=======
=======
>>>>>>> fastadmin/master
        // ??????
        $author = $input->getOption('author');
        // ??????
        $module = $input->getOption('module');

        $moduleDir = APP_PATH . $module . DS;
<<<<<<< HEAD
>>>>>>> fastadmin/master
=======
>>>>>>> fastadmin/master
        if (!is_dir($moduleDir)) {
            throw new Exception('module not found');
        }

        if (version_compare(PHP_VERSION, '7.0.0', '<')) {
            if (extension_loaded('Zend OPcache')) {
                $configuration = opcache_get_configuration();
                $directives = $configuration['directives'];
                $configName = request()->isCli() ? 'opcache.enable_cli' : 'opcache.enable';
                if (!$directives[$configName]) {
                    throw new Exception("Please make sure {$configName} is turned on, Get help:https://forum.fastadmin.net/d/1321");
                }
            } else {
                throw new Exception("Please make sure opcache already enabled, Get help:https://forum.fastadmin.net/d/1321");
            }
        }
<<<<<<< HEAD
<<<<<<< HEAD

        //????????????
        $controller = $input->getOption('controller') ?: [];
        if (!$controller) {
=======
        //????????????
        $controller = $input->getOption('controller') ?: '';
        if(!$controller) {
>>>>>>> fastadmin/master
=======
        //????????????
        $controller = $input->getOption('controller') ?: '';
        if(!$controller) {
>>>>>>> fastadmin/master
            $controllerDir = $moduleDir . Config::get('url_controller_layer') . DS;
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($controllerDir),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                if (!$file->isDir() && $file->getExtension() == 'php') {
                    $filePath = $file->getRealPath();
                    $classes[] = $this->get_class_from_file($filePath);
                }
            }
<<<<<<< HEAD
<<<<<<< HEAD
        } else {
            foreach ($controller as $index => $item) {
                $filePath = $moduleDir . Config::get('url_controller_layer') . DS . $item . '.php';
                $classes[] = $this->get_class_from_file($filePath);
            }
        }

=======
=======
>>>>>>> fastadmin/master
        }
        else{
            foreach ($controller as $index => $item) {
                $filePath=$moduleDir . Config::get('url_controller_layer') . DS .$item.'.php';
                $classes[] = $this->get_class_from_file($filePath);
            }
        }
<<<<<<< HEAD
>>>>>>> fastadmin/master
=======
>>>>>>> fastadmin/master
        $classes = array_unique(array_filter($classes));

        $config = [
            'sitename'    => config('site.name'),
            'title'       => $title,
<<<<<<< HEAD
<<<<<<< HEAD
            'author'      => config('site.name'),
=======
            'author'      => $author,
>>>>>>> fastadmin/master
=======
            'author'      => $author,
>>>>>>> fastadmin/master
            'description' => '',
            'apiurl'      => $url,
            'language'    => $language,
        ];
<<<<<<< HEAD
<<<<<<< HEAD
        try {
            $builder = new Builder($classes);
            $content = $builder->render($template_file, ['config' => $config, 'lang' => $lang]);
        } catch (\Exception $e) {
            print_r($e);
        }
=======
        $builder = new Builder($classes);
        $content = $builder->render($template_file, ['config' => $config, 'lang' => $lang]);

>>>>>>> fastadmin/master
=======
        $builder = new Builder($classes);
        $content = $builder->render($template_file, ['config' => $config, 'lang' => $lang]);

>>>>>>> fastadmin/master
        if (!file_put_contents($output_file, $content)) {
            throw new Exception('Cannot save the content to ' . $output_file);
        }
        $output->info("Build Successed!");
    }

    /**
     * get full qualified class name
     *
     * @param string $path_to_file
     * @return string
     * @author JBYRNE http://jarretbyrne.com/2015/06/197/
     */
    protected function get_class_from_file($path_to_file)
    {
        //Grab the contents of the file
        $contents = file_get_contents($path_to_file);

        //Start with a blank namespace and class
        $namespace = $class = "";

        //Set helper values to know that we have found the namespace/class token and need to collect the string values after them
        $getting_namespace = $getting_class = false;

        //Go through each token and evaluate it as necessary
        foreach (token_get_all($contents) as $token) {

            //If this token is the namespace declaring, then flag that the next tokens will be the namespace name
            if (is_array($token) && $token[0] == T_NAMESPACE) {
                $getting_namespace = true;
            }

            //If this token is the class declaring, then flag that the next tokens will be the class name
            if (is_array($token) && $token[0] == T_CLASS) {
                $getting_class = true;
            }

            //While we're grabbing the namespace name...
            if ($getting_namespace === true) {

                //If the token is a string or the namespace separator...
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {

                    //Append the token's value to the name of the namespace
                    $namespace .= $token[1];
                } elseif ($token === ';') {

                    //If the token is the semicolon, then we're done with the namespace declaration
                    $getting_namespace = false;
                }
            }

            //While we're grabbing the class name...
            if ($getting_class === true) {

                //If the token is a string, it's the name of the class
                if (is_array($token) && $token[0] == T_STRING) {

                    //Store the token's value as the class name
                    $class = $token[1];

                    //Got what we need, stope here
                    break;
                }
            }
        }

        //Build the fully-qualified class name and return it
        return $namespace ? $namespace . '\\' . $class : $class;
    }
}
