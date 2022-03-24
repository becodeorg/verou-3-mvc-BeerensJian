<?php

declare(strict_types=1);

class Article
{
    public int $id;
    public string $title;
    public ?string $description;
    public ?string $publishDate;
    public ?string  $url;

    public function __construct(string $title, ?string $description, ?string $publishDate, ?int $id, string $url = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->publishDate = $publishDate;
        $this->url = $url;
    }

    public function formatPublishDate($format = 'd-m-Y')
    {
        // TODO: return the date in the required format
        $unixtime = strtotime($this->publishDate);
        return date($format, $unixtime);
    }

    public function getImage() 
    {
        if ($this-> url != null) {
            return "<img src=\"{$this->url}\" >";
        }
    }
}