<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;

/**
 * Class DummyApiController
 * @package App\Controller
 */
class DummyApiController extends AbstractController implements TokenAuthenticatedController
{
    private $testJson = [
      1 => [
          'name' => 'Martin Ashcroft'
      ],
      2 => [
          'name' => 'David Slack'
      ],
      3 => [
        'name' => 'Ed Fletcher'
      ]
    ];

    private $apiResponse = [
        'success' => false,
        'data' => null
    ];


    /**
     * @param $userId
     * @return JsonResponse
     */
    public function getUserDetails($userId)
    {
        $this->isValidUserId($userId);
        if (array_key_exists($userId, $this->testJson)) {
            $this->apiResponse['success'] = true;
            $this->apiResponse['data'] = $this->testJson[$userId];
        }

        return new JsonResponse(
            $this->apiResponse
        );
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */

    public function create(Request $request, ValidatorInterface $validator) : JsonResponse
    {
        $name = $request->get('name');
        $user = new User();
        $user->setName($name);
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->returnErrorResponse($errors);
        }
        $this->apiResponse['success'] = true;
        $this->apiResponse['data'] = [
            'id' => 4,
            'name' => $name
        ];
        return new JsonResponse(
            $this->apiResponse
        );
    }

    /**
     * @param $userId
     */
    private function isValidUserId($userId)
    {
        if (!array_key_exists($userId, $this->testJson)) {
            $this->returnInvalidUserIdResponse($userId);
        }
    }

    /**
     * @param $userId
     * @return JsonResponse
     */
    private function returnInvalidUserIdResponse($userId) : JsonResponse
    {
        $this->apiResponse['data'] = 'Error, user ID ' . $userId . ' not found';

        return new JsonResponse(
            $this->apiResponse
        );
    }

    /**
     * @param $errors
     * @return JsonResponse
     */
    private function returnErrorResponse($errors) : JsonResponse
    {
        $responseErrors = [];
        foreach ($errors as $violation) {
            $responseErrors[] = $violation->getMessage();
        }
        $this->apiResponse['data'] = $responseErrors;
        return new JsonResponse($this->apiResponse);
    }
}