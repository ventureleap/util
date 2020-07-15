<?php

namespace VentureLeapUtilBundle\Controller;

use VentureLeapUtilBundle\Entity\Asset;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/asset")
 */
class AssetController extends Controller
{
    /**
     * @Route("/remove/{asset}", name="venture_leap_util_asset_remove")
     *
     * @param Asset   $asset
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeAssetAction(Asset $asset, Request $request)
    {
        $this->get('venture_leap_util_entity_manager')->remove($asset);
        $this->get('venture_leap_util_asset_manager')->removeAsset($asset);

        return new RedirectResponse($request->headers->get('referer'));
    }
}
