<?php 

namespace App\Steven\CustomVendor;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\BootstrapThreePresenter;

class PaginationLinks extends BootstrapThreePresenter {

    public static function makeLengthAware($data, $total, $perPage)
    {
        $paginator = new LengthAwarePaginator(
            $data,
            $total,
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]);

        return $paginator;
    }

    public function render()
    {
        if ($this->hasPages())
        {
            return sprintf(
                '<ul class="pagination">%s %s %s %s %s</ul>',
                $this->getFirstButton(),
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton(),
                $this->getLastButton()
            );
        }

        return '';
    }

    private function getFirstButton(){

        $text = '←';
        if ($this->paginator->currentPage() == 1) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->paginator->url(1);
        return $this->getPageLinkWrapper($url, $text, 'last');
    }

    private function getLastButton(){

        $text = '→';

        if ($this->paginator->currentPage() == $this->paginator->lastPage()) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->paginator->url(
            $this->paginator->lastPage()
        );
        return $this->getPageLinkWrapper($url, $text, 'last');
    }
}