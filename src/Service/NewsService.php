<?php

namespace App\Service;

use App\Repository\NewsRepository;
use App\Entity\News;
use Api\Dto\NewsDto;
use jcobhams\NewsApi\NewsApi;
use jcobhams\NewsApi\NewsApiException;
use Doctrine\Persistence\ManagerRegistry;

class NewsService  implements NewsStrategyInterface
{
    public function __construct(
        private readonly string         $apiKeyNews,
        private readonly NewsRepository $newsRepository,
        private ManagerRegistry $doctrine,
    )
    {
    }

    /**
     * @throws NewsApiException
     */
    public function handle(): void
    {
        $this->loadNews();
    }

    /**
     * @throws NewsApiException
     */
    private function loadNews(): ?NewsDto
    {
        $newsApi = (new NewsApi($this->apiKeyNews))->getEverything('bitcoin');
        $entityManager = $this->doctrine->getManager();
        foreach($newsApi->articles as $field) {
            $news = (new News())
                ->setTitle($field->title)
                ->setImage($field->urlToImage)
                ->setDescription(mb_strimwidth($field->description , 0, 40, "...") );
            $entityManager->persist($news);
        }
        $entityManager->flush();

        return null;
    }


    private function test(): string
    {
        $messages = [
            '2 Crypto Stocks to Avoid Like the Plague in September',
            'US stocks close lower as 10-year yield holds above 3% amid rate-hike bets',
            'The founder of a crypto powerhouse says Meta and Microsoft ',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }

}
