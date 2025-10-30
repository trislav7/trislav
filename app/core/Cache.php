<?php
class Cache {
    private $cachePath;
    private $cacheTime;
    
    public function __construct($cacheTime = 3600) {
        $this->cachePath = ROOT_PATH . '/cache/';
        $this->cacheTime = $cacheTime;
        
        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }
    
    public function get($key) {
        $filename = $this->cachePath . md5($key) . '.cache';
        
        if (file_exists($filename) && (time() - filemtime($filename)) < $this->cacheTime) {
            return unserialize(file_get_contents($filename));
        }
        
        return false;
    }
    
    public function set($key, $data) {
        $filename = $this->cachePath . md5($key) . '.cache';
        file_put_contents($filename, serialize($data));
    }
    
    public function delete($key) {
        $filename = $this->cachePath . md5($key) . '.cache';
        if (file_exists($filename)) {
            unlink($filename);
        }
    }
    
    public function clear() {
        $files = glob($this->cachePath . '*.cache');
        foreach ($files as $file) {
            unlink($file);
        }
    }
    
    public function clearByPattern($pattern) {
        $files = glob($this->cachePath . '*.cache');
        foreach ($files as $file) {
            if (strpos($file, $pattern) !== false) {
                unlink($file);
            }
        }
    }
}