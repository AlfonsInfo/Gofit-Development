abstract class FormResetStatus{
  const FormResetStatus();
}

class InitialFormStatus extends FormResetStatus{
  const InitialFormStatus();
}

class FormSubmitting extends FormResetStatus{}

class SubmissionSuccess extends FormResetStatus{}


class SubmissionFailed extends FormResetStatus{
  final Exception? exception;
  
  SubmissionFailed({this.exception});
}