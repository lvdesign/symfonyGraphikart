<?php
namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


/* Live event cycle de Doctrine */
class ImageCacheSubscriber implements EventSubscriber
{
    
    /**
     * @var cacheManager
     */
    private $cacheManager;

    /**
     * @var uploaderHelper
     */
    private $uploaderHelper;


    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager= $cacheManager;
        $this->uploaderHelper= $uploaderHelper;

    }

    
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }


    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof Picture) { return ;}        
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        // dump($args->getEntity());
        // dump($args->getObject());

        if($entity instanceof Picture) { return ;} 
        if($entity->getImageFile() instanceof UploadedFile )        
        {
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }


}