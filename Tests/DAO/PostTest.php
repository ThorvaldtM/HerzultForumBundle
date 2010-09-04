<?php

namespace Bundle\ForumBundle\Tests\DAO;
use Bundle\ForumBundle\Test\WebTestCase;

class PostTest extends WebTestCase
{
    
    public function testMessage()
    {
        $class = $this->postClass;
        $post = new $class($this->getMock($this->topicClass));
        $this->assertAttributeEmpty('message', $post, 'the message is empty during creation');

        $post->setMessage('Foo bar bla bla...');
        $this->assertAttributeEquals('Foo bar bla bla...', 'message', $post, '::setMessage() sets the message');
        $this->assertEquals('Foo bar bla bla...', $post->getMessage(), '::getMessage() gets the message');
    }

    public function testCreatedAt()
    {
        $class = $this->postClass;
        $post = new $class($this->getMock($this->topicClass));
        $this->assertAttributeEmpty('createdAt', $post, 'the creation timestamp is empty during creation');

        $date = new \DateTime('now');
        $post->setCreatedNow();
        $this->assertAttributeInstanceOf('DateTime', 'createdAt', $post, '::setCreatedNow() sets the creation timestamp as a DateTime object');
        $this->assertAttributeEquals($date, 'createdAt', $post, '::setCreatedNow() sets the creation timestamp as now');
        $this->assertEquals($date, $post->getCreatedAt(), '::getCreatedAt() gets the creation timestamp');
    }
    
    public function testUpdatedAt()
    {
        $class = $this->postClass;
        $post = new $class($this->getMock($this->topicClass));
        $this->assertAttributeEmpty('updatedAt', $post, 'the update timestamp is empty during creation');

        $date = new \DateTime('now');
        $post->setUpdatedNow();
        $this->assertAttributeInstanceOf('DateTime', 'updatedAt', $post, '::setUpdatedNow() sets the update timestamp as a DateTime object');
        $this->assertAttributeEquals($date, 'updatedAt', $post, '::setUpdatedNow() sets the update timestamp as now');
        $this->assertEquals($date, $post->getUpdatedAt(), '::getUpdatedAt() gets the update timestamp');
    }    

    public function testTimestamps()
    {
        $om = $this->getService('forum.object_manager');

        $categoryClass = $this->categoryClass;
        $category = new $categoryClass();
        $category->setName('Test Category');
        
        $topicClass = $this->topicClass;
        $topic = new $topicClass();
        $topic->setSubject('Testing timestampable functionality');
        $topic->setCategory($category);
        
        $postClass = $this->postClass;
        $post = new $postClass($topic);
        $post->setMessage('Foo bar bla bla...');
        
        $om->persist($category);
        $om->persist($topic);
        $om->persist($post);
        $om->flush();

        $this->assertAttributeInstanceOf('DateTime', 'createdAt', $post, 'the creation timestamp is automatically set on insert');
        $this->assertAttributeEmpty('updatedAt', $post, 'the update timestamp is not set on insert');

        $post->setMessage('Updated foo bar bla bla...');

        $om->flush();

        $this->assertAttributeInstanceOf('DateTime', 'updatedAt', $post, 'the update timestamp is automatically set on update');
    }

}
