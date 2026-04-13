]
  /// for a full definition of this [Rect].
  ///
  /// If `descendant` is null, this is a no-op and `rect` is returned.
  ///
  /// If both `descendant` and `rect` are null, null is returned because there is
  /// nothing to be shown in the viewport.
  ///
  /// The `duration` parameter can be set to a non-zero value to animate the
  /// target object into the viewport with an animation defined by `curve`.
  ///
  /// See also:
  ///
  /// * [RenderObject.showOnScreen], overridden by [RenderViewportBase] and the
  ///   renderer for [SingleChildScrollView] to delegate to this method.
  static Rect? showInViewport({
    RenderObject? descendant,
    Rect? rect,
    required RenderAbstractViewport viewport,
    required ViewportOffset offset,
    Duration duration = Duration.zero,
    Curve curve = Curves.ease,
  }) {
    if (descendant == null) {
      re