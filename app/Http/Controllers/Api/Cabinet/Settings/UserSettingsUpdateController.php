<?php

declare(strict_types=1);

use Illuminate\Http\Request;

class UserSettingsUpdateController
{
    public function __invoke(
        Request $request,
        // UserSettingsUpdateRequest $request мог бы быть тут, но я не знаю как принято в команде
        UserSettingsUpdateUseCaseInterface $useCase
    ): void // : какой-то Output формат
    {

        $dto = $request->except('_token');
        $useCase->execute();
        // какой-то презентер для API
    }
}
