<?php

namespace Bytesoft\Base\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use URL;

class BaseHttpResponse implements Responsable
{
    /**
     * @var bool
     */
    protected $error = false;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $previousUrl = '';

    /**
     * @var string
     */
    protected $nextUrl = '';

    /**
     * @var bool
     */
    protected $withInput = false;

    /**
     * @var int
     */
    protected $code = 200;

    /**
     * @param $error
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function setError(bool $error = true): self
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @param $message
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function setMessage($message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param $data
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $previous_url
     * @return BaseHttpResponse
     */
    public function setPreviousUrl($previous_url): self
    {
        $this->previousUrl = $previous_url;
        return $this;
    }

    /**
     * @param string $next_url
     * @return BaseHttpResponse
     */
    public function setNextUrl($next_url): self
    {
        $this->nextUrl = $next_url;
        return $this;
    }

    /**
     * @param bool $with_input
     * @return BaseHttpResponse
     */
    public function withInput(bool $with_input = true): self
    {
        $this->withInput = $with_input;
        return $this;
    }

    /**
     * @param int $code
     * @return BaseHttpResponse
     */
    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse
     * @author Bytesoft
     */
    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            return response()
                ->json([
                    'error' => $this->error,
                    'data' => $this->data,
                    'message' => $this->message,
                ]);
        }

        if ($request->input('submit') === 'save' && !empty($this->previousUrl)) {
            return $this->responseRedirect($this->previousUrl);
        } elseif (!empty($this->nextUrl)) {
            return $this->responseRedirect($this->nextUrl);
        }

        return $this->responseRedirect(URL::previous());
    }

    /**
     * @param string $url
     * @return \Illuminate\Http\RedirectResponse
     * @author Bytesoft
     */
    protected function responseRedirect($url)
    {
        if ($this->withInput) {
            return redirect()
                ->to($url)
                ->with($this->error ? 'error_msg' : 'success_msg', $this->message)
                ->withInput();
        }

        return redirect()
            ->to($url)
            ->with($this->error ? 'error_msg' : 'success_msg', $this->message);
    }
}