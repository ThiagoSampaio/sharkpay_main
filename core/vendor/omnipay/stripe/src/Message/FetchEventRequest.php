ero] or [ViewportOffset.fixed].
  RenderViewport({
    super.axisDirection,
    required super.crossAxisDirection,
    required super.offset,
    double anchor = 0.0,
    List<RenderSliver>? children,
    RenderSliver? center,
    super.cacheExtent,
    super.cacheExtentStyle,
    super.clipBehavior,
  }) : assert(anchor >= 0.0 && anchor <= 1.0),
       assert(cacheExtentStyle != CacheExtentStyle.viewport || cacheExtent != null),
       _anchor = anchor,
       _center = center {
    addAll(children);
    if (center == null && firstChild != null) {
      _center = firstChild;
    }
  }

  /// If a [RenderAbstractViewport] overrides
  /// [RenderObject.describeSemanticsConfiguration] to add the [SemanticsTag]
  /// [useTwoPaneSemantics] to its [SemanticsConfiguration], two semantics nodes
  /// will be used to represent the viewport with its associated scrolling
  /// actions in the semantics tree.
  ///
  /// Two semantics nodes (an i